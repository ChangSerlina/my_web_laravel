<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\service\db_common;
use Illuminate\Log;

class ParkingFeeController extends Controller
{
    public function parkingFee_show($page_chose_1 = 'parkingFee')
    {
        $articles = db_common::select_by_route($page_chose_1);
        return view('parkingFee', compact('page_chose_1', 'articles'));
    }

    /**
     * 產生驗證碼
     */
    function create_captcha()
    {
        try {
            $str = $this->rand_str(4);
            $width = 90;
            $height = 45;

            $image = imagecreatetruecolor($width, $height);

            if (!$image) {
                die("Unable to create image.");
            }

            // 分配背景色
            $background_color = imagecolorallocate($image, 255, 255, 204); // 米黃色
            imagefill($image, 0, 0, $background_color);
            for ($i = 0; $i <= 9; $i++) {
                // 繪製隨機的干擾線條
                imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $this->rand_color($image));
            }
            for ($i = 0; $i <= 100; $i++) {
                // 繪製隨機的干擾點
                imagesetpixel($image, rand(0, $width), rand(0, $height), $this->rand_color($image));
            }

            /**
             * 查詢 linux 系統字體
             */
            // exec("fc-list | grep -i dejavu")

            // 設置字體文件路徑
            $font = public_path('fonts/DejaVuSans.ttf');

            if (!file_exists($font)) {
                die("Font file not found.");
            }

            // 繪製驗證碼中的字元
            for ($i = 0; $i < 4; $i++) {
                // 依序為 圖片,字體大小,旋轉角度,字元間距,垂直位置
                imagettftext($image, rand(20, 25), rand(-45, 45), $i * 20 + 12, rand(30, 40), $this->rand_color($image), $font, $str[$i]);
            }

            ob_start();
            imagepng($image);
            $imageData = ob_get_clean();
            imagedestroy($image);

            return response($imageData)->header('Content-Type', 'image/png');
        } catch (\Exception $e) {
            \Log::error('Captcha Error: ' . $e->getMessage());
            return response('Error generating captcha', 500);
        }
    }

    /**
     * 隨機字串生成函數
     */
    function rand_str($length)
    {
        // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars = '0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        //儲存驗證碼
        session(['captcha_code' => $str]);

        return $str;
    }

    /**
     * 隨機顏色生成函數
     */
    function rand_color($image)
    {
        return imagecolorallocate($image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 255));
    }

    /**
     * 檢查驗證碼
     */
    function check_captcha(Request $request)
    {
        $userInput = $request->input('check');
        $captcha = session('captcha_code');

        if (strcasecmp($userInput, $captcha) == 0) {    // strcasecmp() 不區分大小寫
            return response()->json(['success' => true, 'message' => '驗證成功']);
        } else {
            return response()->json(['success' => false, 'message' => '驗證碼輸入錯誤']);
        }

        return response()->json(['success' => false, 'message' => '無效的操作']);
    }
}
