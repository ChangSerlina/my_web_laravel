<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        // 1. 新增暫存欄位
        Schema::table('article', function (Blueprint $table) {
            $table->date('date_new')->nullable()->after('date');
        });

        // 2. 將原本字串日期轉成真正 DATE
        DB::table('article')->select('id', 'date')->get()->each(function ($row) {
            if (!empty($row->date)) {
                try {
                    // 原格式：Oct 21, 2024
                    $converted = Carbon::createFromFormat('M d, Y', trim($row->date));

                    DB::table('article')
                        ->where('id', $row->id)
                        ->update([
                            'date_new' => $converted->format('Y-m-d'),
                        ]);
                } catch (\Exception $e) {
                    // 格式不符時避免 migration 失敗
                }
            }
        });

        // 3. 刪除舊欄位
        Schema::table('article', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        // 4. 將新欄位改名
        Schema::table('article', function (Blueprint $table) {
            $table->renameColumn('date_new', 'date');
        });
    }

    public function down(): void
    {
        // 1. 新增暫存字串欄位
        Schema::table('article', function (Blueprint $table) {
            $table->string('date_string')->nullable()->after('date');
        });

        // 2. 將 DATE 轉成字串格式 Mon DD, YYYY
        DB::table('article')->select('id', 'date')->get()->each(function ($row) {
            if (!empty($row->date)) {
                try {
                    // 將 2024-10-21 轉成 Oct 21, 2024
                    $formatted = \Carbon\Carbon::parse($row->date)->format('M d, Y');

                    DB::table('article')
                        ->where('id', $row->id)
                        ->update([
                            'date_string' => $formatted,
                        ]);
                } catch (\Exception $e) {
                    // 避免 rollback 失敗
                }
            }
        });

        // 3. 刪掉 DATE 欄位
        Schema::table('article', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        // 4. 將字串欄位改名回 date
        Schema::table('article', function (Blueprint $table) {
            $table->renameColumn('date_string', 'date');
        });
    }
};
