<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\service\db_common;

class ParkingFeeController extends Controller
{
    public function parkingFee_show($page_chose_1 = 'parkingFee')
    {
        $articles = db_common::select_by_route($page_chose_1);
        return view('parkingFee', compact('page_chose_1', 'articles'));
    }
}
