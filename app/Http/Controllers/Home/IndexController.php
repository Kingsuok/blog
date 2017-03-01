<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;


class IndexController extends CommonController
{
    public function index()
    {
//        //点击最高的（6篇）文章
//        $hot = Article::orderBy('art_view','desc')->take(6)->get();
        //图文列表（带分页）
        $art = Article::orderBy('art_time','desc')->paginate(5);
//        //最新发表文章(8篇)
//        $new = Article::orderBy('art_time','desc')->take(8)->get();
        //友情链接
        $links = Links::orderBy('link_order','asc')->get();
//        //网站配置,不是从数据库读取，而是从config文件夹下的web.php读取的
//        $config = Config::get('web');

        $sub = Category::where('cate_pid',0)->get();
        return view('home.index', compact('hot','art','new','links','sub'));
    }

    // get, /list
    public function category($cate_id)
    {
        Category::where('cate_id',$cate_id)->increment('cate_view');
        $field = Category::find($cate_id);
        $art = Article::where('art_cat',$cate_id)->orderBy('art_time','desc')->paginate(4);
        $sub = Category::where('cate_pid',$cate_id)->get();
        return view('home.list', compact('field','art','sub'));
    }
    // get, /article
    public function article($art_id)
    {
        Article::where('art_id',$art_id)->increment('art_view');
        // 由于 文章页面，要用到 相对应的 分类信息，所以使用 join ，让category和article 进行jion
        $field = Article::Join('category','category.cate_id','=','article.art_cat')->where('art_id',$art_id)->first();
        $tree = (new Category())->getReverseCategory($field['art_cat']);
        $article['prior'] = Article::where('art_id','<',$field['art_id'])->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$field['art_id'])->orderBy('art_id','asc')->first();
        $related = Article::where('art_cat',$field['art_cat'])->orderBy('art_id','desc')->take(6)->get();
        return view('home.article',compact('field','tree','article','related'));
    }
}
