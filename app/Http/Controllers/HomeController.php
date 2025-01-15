<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home_show($page_chose = null)
    {
        switch ($page_chose) {
            case 'Roof_Party':
                $page_chose_1 = 'include.Roof_Party';
                return view('home', compact('page_chose_1'));
            case 'Craft_Beer':
                $page_chose_1 = 'include.Craft_Beer';
                return view('home', compact('page_chose_1'));
            default:
                $page_chose_1 = 'include.container';
                return view('home', compact('page_chose_1'));
        }
    }
}
