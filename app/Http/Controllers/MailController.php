<?php
/**
 * 發送測試信件
 * 
 * 範例請求方式
 * curl -X POST http://localhost/sendTestMail \
 * -d "email=serlina0504@gmail.com" \
 * -d "cc=testserlina@gmail.com" \
 * -d "bcc=deniel87deniel87@gmail.com" \
 * -d "name=Serlinaweb 會員"
 * 
 * 使用瀏覽器開 /sendTestMail?email=serlina0504@gmail.com&cc=testserlina@gmail.com&bcc=deniel87deniel87@gmail.com&name=Serlinaweb%20會員
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class MailController extends Controller
{
    public function send(Request $request)
    {
        // 驗證輸入參數
        $validated = $request->validate([
            'email' => 'required|email',
            'cc'    => 'nullable|email',
            'bcc'   => 'nullable|email',
            'name'  => 'nullable|string|max:50',
        ]);

        $to = $validated['email'];
        $cc = $validated['cc'] ?? null;
        $bcc = $validated['bcc'] ?? null;
        $name = $validated['name'] ?? '收件者';

        try {
            // 使用 Blade 樣板寄送 HTML 郵件
            Mail::send('emails.test', ['name' => $name], function ($message) use ($to, $cc, $bcc) {
                $message->to($to)
                    ->subject('📧 Serlinaweb 測試信件');

                if ($cc) {
                    $message->cc($cc);
                }

                if ($bcc) {
                    $message->bcc($bcc);
                }
            });

            return response()->json([
                'status' => 'success',
                'message' => '郵件已成功發送',
                'to' => $to,
                'cc' => $cc,
                'bcc' => $bcc,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ 郵件發送失敗：' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => '郵件發送失敗',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // 顯示驗證信通知頁面
    public function notice()
    {
        return view('auth.verify-email');
    }

    // 處理驗證信連結
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/admin');
    }

    // 重新發送驗證信
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '已重新發送驗證信!');
    }
}
