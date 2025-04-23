<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParkingFeeCheckController extends Controller
{
    public function parkingFeeCheck_show(Request $request)
    {
        $carid      = $request->input('carid');
        $cartype    = $request->input('cartype');
        $location   = $request->input('location');

        switch($cartype){
            case "C" :
                $_cartype = "汽車";
                break;
            case "M" :
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

        switch($location){
            case "Keelung" :
                $cityName = "基隆市";
                $_API = "https://park.klcg.gov.tw/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taipei" :
                $cityName = "台北市";
                $_API = "https://trafficapi.pma.gov.taipei/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "NewTaipei" :
                $cityName = "新北市";
                $_API = "https://trafficapi.traffic.ntpc.gov.tw/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taoyuan" :
                $cityName = "桃園市";
                $_API = "https://bill-epark.tycg.gov.tw/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Hsinchu" :
                $cityName = "新竹市";
                $_API = "https://his.futek.com.tw:5443/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Hsinchu_s" :
                $cityName = "新竹縣";
                $_API = "https://hcpark.hchg.gov.tw/NationalParkingPayBillInquiry/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taichung" :
                $cityName = "台中市";
                $_API = "http://tcparkingapi.taichung.gov.tw:8081/NationalParkingPayBillInquiry.Api/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Changhua" :
                $cityName = "彰化縣";
                $_API = "https://chpark.chcg.gov.tw/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Chiayi" :
                $cityName = "嘉義市";
                $_API = "https://parking.chiayi.gov.tw/cypark/api/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Tainan" :
                $cityName = "台南市";
                $_API = "http://parkingbill.tainan.gov.tw/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Kaohsiung" :
                $cityName = "高雄市";
                $_API = "https://kpp.tbkc.gov.tw/parking/V1/parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Pingtung" :
                $cityName = "屏東縣";
                $_API = "https://8voc0wuf1g.execute-api.ap-southeast-1.amazonaws.com/default/pingtung/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            case "Taitung" :
                $cityName = "台東縣";
                $_API = "https://tt.guoyun.com.tw/TrafficPayBill/Parking/PayBill/CarID/$carid/CarType/$cartype";
                break;
            default:
                break;
        };

        return view('parkingFeeCheck', compact('carid', 'cityName', '_cartype', '_API'));
    }
}
