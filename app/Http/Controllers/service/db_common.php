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

    public static function select_pre_by_id_class($id,$class)
    {
        $route = article::where('id', '<', $id)
                  ->where('class', $class)
                  ->orderBy('id', 'desc')
                  ->select('route') // 指定只取出 route 欄位
                  ->first();
        return $route;
    }

    public static function select_next_by_id_class($id,$class)
    {
        $route = article::where('id', '>', $id)
                  ->where('class', $class)
                  ->orderBy('id', 'asc')
                  ->select('route') // 指定只取出 route 欄位
                  ->first();
        return $route;
    }
}