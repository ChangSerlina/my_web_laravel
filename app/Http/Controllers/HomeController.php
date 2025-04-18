<?php

namespace App\Http\Controllers;

use App\Models\article;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home_show($page_chose = null)
    {
        if(!empty($page_chose)){
            $articles = $this->select_by_route($page_chose);
        }else{
            $page_chose = 'travel';
            $articles = $this->select_by_class($page_chose);
        }

        switch ($page_chose) {
            case 'osaka':
                $page_chose_1 = 'include.osaka';
                return view('home', compact('page_chose_1', 'articles'));
            case 'tainan':
                $page_chose_1 = 'include.tainan';
                return view('home', compact('page_chose_1', 'articles'));
            case 'malaysia':
                $page_chose_1 = 'include.malaysia';
                return view('home', compact('page_chose_1', 'articles'));
            default:
                $page_chose_1 = 'include.container';
                return view('home', compact('page_chose_1', 'articles'));
        }
    }

    public function select_by_route($route)
    {
        $article = article::where('route', $route)->orderBy('date', 'desc')->get();
        return $article;
    }

    public function select_by_class($class)
    {
        $article = article::where('class', $class)->orderBy('date', 'desc')->get();
        return $article;
    }
}
