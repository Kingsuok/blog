@extends('layouts.home')
@section('title')
    <title>{{$data['config']['web_title']}}</title>
    <meta name="keywords" content="{{$data['config']['keywords']}}" />
    <meta name="description" content="{{$data['config']['web_description']}}" />
@endsection
@section('content')
    <div class="banner">
        <section class="box">
            <ul class="texts">
                <p>I can't change the direction of the wind,
                <p>but I can adjust my sails to always reach my destination.</p>
                <p>         --Jimmy Dean</p>
            </ul>
            <div class="avatar"><a href="javascript:;"><span></span></a> </div>
        </section>
    </div>
    <div class="template">
        <div class="box">
            <h3>
                <p><span>Blogger</span> Recommended</p>
            </h3>
            <ul>
                @foreach($hot as $value)
                    <li><a href="{{url('article/'.$value['art_id'])}}"  target="_blank"><img src="{{url($value['art_thumb']==null? $data['config']['default_picture']:$value['art_thumb'])}}"></a><span>{{$value['art_title']}}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
    <article>
        <h2 class="title_tj">
            <p><span>Articles</span></p>
        </h2>
        <div class="bloglist left">
            @foreach($art as $value)
                <h3>{{$value['art_title']}}</h3>
                <figure><img src="{{url($value['art_thumb']==null? $data['config']['default_picture']:$value['art_thumb'])}}"></figure>
                <ul>
                    <p>{{$value['art_description']}}</p>
                    <a title="{{$value['art_id']}}" href="{{url('article/'.$value['art_id'])}}" target="_blank" class="readmore">read more>></a>
                </ul>
                <p class="dateview"><span>　{{date('Y/m/d',$value['art_time'])}}</span><span>Author：{{$value['art_editor']}}</span></p>
            @endforeach
            <div class="page">
                {{$art->links()}}
            </div>
        </div>
        <aside class="right">
            @if($sub->all())
                <div class="rnav">
                    <ul>
                        @foreach($sub as $k=>$v)
                            <li class="rnav{{$k+1}}"><a href="{{url('category/'. $v['cate_id'])}}" target="_blank">{{$v['cate_name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h3 class="ph">
                <p><span>share</span></p>
            </h3>
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="news" style="float: left">
                @parent
                <h3 class="links">
                    <p><span>Blogroll</span></p>
                </h3>
                <ul class="website">
                    @foreach($links as $link)
                        <li><a href="{{url($link['link_url'])}}" target="_blank" style="font:italic bold 12px/30px Georgia, serif; ">{{$link['link_name']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </article>
@endsection
