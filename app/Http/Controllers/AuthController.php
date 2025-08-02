<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;    // Socialite for OAuth
use Google\Client;  // Google Client for OAuth id_token
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 前台登入相關方法 (email 認證)
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // 安全性
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => '帳號或密碼錯誤',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // 後台.Google OAuth 登入相關方法
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email']) // 確保包含 openid
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // 檢查 email 是否已經存在於系統中
            $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = \App\Models\User::create([
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(), // 儲存 Google ID
                    'password' => bcrypt(Str::random(16)), // 隨機密碼，因為 Google 登入不需要密碼
                ]);
            } else {
                // 如果已經存在，更新個人資料
                \App\Models\User::where('email', $googleUser->getEmail())->update([
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(), // 儲存 Google ID
                ]);
            }

            Auth::login($user);

            if (!$user->canAccessPanel(app(\Filament\Panel::class))) {
                Auth::logout();
                return redirect('/admin/login')->withErrors(['auth' => '很抱歉，您沒有權限進入後台!請與管理人員聯絡']);
            } else {
                // 如果有權限，導向到後台
                return redirect('/admin');
            }
        } catch (\Exception $e) {
            return redirect('/admin/login')->withErrors(['auth' => 'Google 登入失敗，請稍後再試。']);
        }
    }
}
