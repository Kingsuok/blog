<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
class CommonController extends Controller
{
    function __construct()
    {   //导航数据
        $navs = Navs::all();
        //网站配置,不是从数据库读取，而是从config文件夹下的web.php读取的
        $config = Config::get('web');
        //点击最高的（6篇）文章
        $hot = Article::orderBy('art_view','desc')->take(6)->get();
        //最新发表文章(8篇)
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        $data = [
            'navs' => $navs,
            'config'=>$config,
        ];
        //View::share('navs',$navs);// this is just to share one data
        View::share('data',$data);// this is to share many data
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
