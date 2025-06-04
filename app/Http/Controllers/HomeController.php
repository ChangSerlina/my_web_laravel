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

        // switch ($page_chose) {
        //     case 'osaka':
        //         $page_chose_1 = 'include.osaka';
        //         return view('home', compact('page_chose_1', 'articles'));
        //     case 'tainan':
        //         $page_chose_1 = 'include.tainan';
        //         return view('home', compact('page_chose_1', 'articles'));
        //     case 'malaysia':
        //         $page_chose_1 = 'include.malaysia';
        //         return view('home', compact('page_chose_1', 'articles'));
        //     default:
        //         $page_chose_1 = 'include.container';
        //         return view('home', compact('page_chose_1', 'articles'));
        // }
    }
}
