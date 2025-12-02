<?php    
namespace App\Http\Controllers\service;

use App\Models\Article;

use Illuminate\Http\Request;

class db_common
{
    public static function select_by_route($route)
    {
        $article = Article::where('route', $route)->orderBy('date', 'desc')->get();
        return $article;
    }

    public static function select_by_class($class)
    {
        $article = Article::where('class', $class)->orderBy('date', 'desc')->get();
        return $article;
    }

    public static function select_pre_by_date_class($date,$class)
    {
        $route = Article::where('date', '<', $date)
                  ->where('class', $class)
                  ->orderBy('date', 'desc')
                  ->select('route', 'title')
                  ->first();
        return $route;
    }

    public static function select_next_by_date_class($date,$class)
    {
        $route = Article::where('date', '>', $date)
                  ->where('class', $class)
                  ->orderBy('date', 'asc')
                  ->select('route', 'title')
                  ->first();
        return $route;
    }
}