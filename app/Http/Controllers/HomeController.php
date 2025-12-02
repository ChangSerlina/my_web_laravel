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
            foreach($articles as $article){
                $date = $article->date ?? null;
                $class = $article->class ?? null;
            }
            
            $pre_article = db_common::select_pre_by_date_class($date,$class) ?? '';
            $next_article = db_common::select_next_by_date_class($date,$class)?? '';
            
            return view('home', compact('page_chose_1', 'articles','pre_article','next_article'));
        }else{
            $page_chose = 'home';
            $articles = db_common::select_by_class($page_chose);
            $page_chose_1 = 'include.default';
            return view('home', compact('page_chose_1', 'articles'));
        }
    }
}
