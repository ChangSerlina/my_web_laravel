<?php

namespace App\Http\Controllers;

use App\Http\Controllers\service\db_common;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use DateTime;

class ParkingFeeCheckController extends Controller
{
    public function parkingFeeCheck_show(Request $request)
    {
        $carid      = $request->input('carid');
        $cartype    = $request->input('cartype');
        $location   = $request->input('location');

        switch ($cartype) {
            case "C":
                $_cartype = "汽車";
                break;
            case "M":
                $_cartype = "機車";
                break;
            default:
                $_cartype = "汽/機車";  // 不應該
                break;
        };

        /**
         * 篩選查詢縣市
         * https://tdx.transportdata.tw/data-service/parkingFee
         */

        switch ($location) {
            case "Keelung":
                $cityName = "基隆市";
                $_API = "https://park.klcg.gov.tw/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taipei":
                $cityName = "台北市";
                $_API = "https://trafficapi.pma.gov.taipei/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "NewTaipei":
                $cityName = "新北市";
                $_API = "https://trafficapi.traffic.ntpc.gov.tw/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taoyuan":
                $cityName = "桃園市";
                $_API = "https://bill-epark.tycg.gov.tw/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Hsinchu":
                $cityName = "新竹市";
                $_API = "https://his.futek.com.tw:5443/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Hsinchu_s":
                $cityName = "新竹縣";
                $_API = "https://hcpark.hchg.gov.tw/NationalParkingPayBillInquiry/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taichung":
                $cityName = "台中市";
                $_API = "http://tcparkingapi.taichung.gov.tw:8081/NationalParkingPayBillInquiry.Api/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Changhua":
                $cityName = "彰化縣";
                $_API = "https://chpark.chcg.gov.tw/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Chiayi":
                $cityName = "嘉義市";
                $_API = "https://parking.chiayi.gov.tw/cypark/api/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Tainan":
                $cityName = "台南市";
                $_API = "http://parkingbill.tainan.gov.tw/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Kaohsiung":
                $cityName = "高雄市";
                $_API = "https://kpp.tbkc.gov.tw/parking/V1/parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Pingtung":
                $cityName = "屏東縣";
                $_API = "https://8voc0wuf1g.execute-api.ap-southeast-1.amazonaws.com/default/pingtung/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taitung":
                $cityName = "台東縣";
                $_API = "https://tt.guoyun.com.tw/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            default:
                break;
        };

        try {
            if (app()->environment('local')) {
                $response = Http::withoutVerifying()->timeout(10)->get($_API);  // 開發先繞過 ssl
            } else {
                $response = Http::timeout(60)->get($_API);  // 設定 60 秒 timeout
            }

            $response = json_decode($response);

            if (empty($response->Result)) {
                $_API = "無待繳停車費紀錄";
            }
            if (!empty($response->Result->Reminders)) {
                $_API = "糟糕...您有欠費紀錄，請盡速繳款，總金額為: " . $response->Result->TotalAmount;
            }
            if (!empty($response->Result)) {
                $bills = $response->Result->Bills;
                $now = new DateTime();
                $closestBill = null;    // 最靠近繳費截止的帳單
                $minDiff = null;        // 最小的時間差

                foreach ($bills as $bill) {
                    $payLimitDateStr = $bill->PayLimitDate;

                    // 檢查日期是否有效
                    if (!empty($payLimitDateStr)) {
                        $payLimitDate = DateTime::createFromFormat('Y-m-d', $payLimitDateStr);

                        // 如果日期格式正確，且還沒過期
                        if ($payLimitDate && $payLimitDate >= $now) {
                            $diff = $payLimitDate->getTimestamp() - $now->getTimestamp();

                            if ($minDiff === null || $diff < $minDiff) {
                                $minDiff = $diff;
                                $closestBill = $bill;
                            }
                        }
                    }
                }

                $_API = "您有 " . $response->Result->TotalCount . " 張待繳停車費紀錄，總金額為: " . $response->Result->TotalAmount . "\n";
                if ($closestBill) {
                    $_API .= "近期繳費截止日為: " . $closestBill->PayLimitDate;
                }
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            logger()->error('Connection timed out: ' . $e->getMessage());
            $_API = "查詢失敗，請稍後再試";
        } catch (RequestException $e) {
            logger()->error('HTTP request error: ' . $e->getMessage());
            $_API = "查詢失敗，請稍後再試";
        } catch (\Exception $e) {
            logger()->error('Unexpected error: ' . $e->getMessage());
            $_API = "查詢失敗，請稍後再試";
        }
        // dd($_API);

        $html = view('parkingFeeCheck', compact('carid', 'cityName', '_cartype', '_API'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}
