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
                $id = $article->id ?? null;
                $class = $article->class ?? null;
            }
            
            $pre_article_routes = db_common::select_pre_by_id_class($id,$class);
            $pre_article_route = $pre_article_routes ? $pre_article_routes['route'] : '';

            $next_article_routes = db_common::select_next_by_id_class($id,$class);
            $next_article_route = $next_article_routes ? $next_article_routes['route'] : '';
            
            return view('home', compact('page_chose_1', 'articles','pre_article_route','next_article_route'));
        }else{
            $page_chose = 'home';
            $articles = db_common::select_by_class($page_chose);
            $page_chose_1 = 'include.default';
            return view('home', compact('page_chose_1', 'articles'));
        }
    }
}
