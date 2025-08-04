<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @group api
 * php artisan test --filter ApiTest
 */

class ApiTest extends TestCase
{
    protected function authenticate()
    {
        // 取得 token
        $response = $this->postJson('/api/getToken', [
            'name' => 'serlina',
            'password' => 'serlina0818',
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');

        return $token;
    }

    /** @can_get_users */
    public function can_get_users()
    {
        $token = $this->authenticate();

        // Assert: 使用 token 呼叫 /user
        $res = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/user');

        // dd($res->json()); // 這裡可以檢查回傳的資料格式

        $res->assertStatus(200);
    }

    /** @can_get_articles */
    public function can_get_articles()
    {
        $token = $this->authenticate();

        $res = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/articles');

        // dd($res->json()); // 這裡可以檢查回傳的資料格式

        $res->assertStatus(200); // 視情況檢查資料格式
    }

    /**
     * @test_token_expired
     */
    public function test_token_expired()
    {
        $res = $this->withHeaders([
            'Authorization' => "Bearer 84b56d6a10e80c02b9bc638e0e3228dfebdd4729be76d99e8f4c668a9e3a7410",
            'Accept' => 'application/json',
        ])->getJson('/api/user');

        // dd($res->json()); // 這裡可以檢查回傳的資料格式

        $res->assertStatus(401); // 應該返回 401 Unauthorized
        $res->assertJson(['message' => 'Unauthenticated.']);
    }
}
