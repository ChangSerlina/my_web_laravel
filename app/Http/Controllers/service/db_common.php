<?php    
namespace App\Http\Controllers\service;

use App\Models\article;

use Illuminate\Http\Request;

class db_common
{
    public static function select_by_route($route)
    {
        $article = article::where('route', $route)->orderBy('date', 'desc')->get();
        return $article;
    }

    public static function select_by_class($class)
    {
        $article = article::where('class', $class)->orderBy('date', 'desc')->get();
        return $article;
    }
}