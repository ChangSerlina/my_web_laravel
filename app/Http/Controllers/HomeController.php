<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\service\db_common;

class HomeController extends Controller
{
    public function home_show($page_chose = null)
    {
        if(!empty($page_chose)){
            $articles = db_common::select_by_route($page_chose);
            $page_chose_1 = 'include.article';
            return view('home', compact('page_chose_1', 'articles'));
        }else{
            $page_chose = 'home';
            $articles = db_common::select_by_class($page_chose);
            $page_chose_1 = 'include.default';
            return view('home', compact('page_chose_1', 'articles'));
        }
    }
}
