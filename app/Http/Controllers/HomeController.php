<?php

namespace App\Http\Controllers;

use App\Models\article;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home_show($page_chose = null)
    {
        $class = 'travel';
        $articles = $this->select_by_class($class) ? $this->select_by_class($class) : null;

        switch ($page_chose) {
            case 'Roof_Party':
                $page_chose_1 = 'include.Roof_Party';
                return view('home', compact('page_chose_1', 'articles'));
            case 'Craft_Beer':
                $page_chose_1 = 'include.Craft_Beer';
                return view('home', compact('page_chose_1', 'articles'));
            default:
                $page_chose_1 = 'include.container';
                return view('home', compact('page_chose_1', 'articles'));
        }
    }

    public function select_by_class($class)
    {
        $article = article::where('class', $class)->orderBy('date', 'desc')->get();
        return $article;
    }
}
