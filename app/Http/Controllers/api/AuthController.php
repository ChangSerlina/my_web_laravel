<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('name', 'password'))) {
            return response()->json(['message' => '帳號或密碼錯誤'], 401);
        }

        $user = Auth::user();
        $tokenResult = $user->createToken($request->name);

        // 取得 token id
        $tokenId = explode('|', $tokenResult->plainTextToken)[0];

        // 直接更新 expires_at 欄位
        DB::table('personal_access_tokens')
            ->where('id', $tokenId)
            ->update(['expires_at' => Carbon::now()->addHours(2)]);

        // 刪除過期 token
        DB::table('personal_access_tokens')
            ->where('expires_at', '<', Carbon::now())
            ->delete();

        return response()->json(['token' => $tokenResult->plainTextToken], 200);
    }
}
