@extends('layouts.home')
@section('title')
    <title>{{$field['name']}}</title>
    <meta name="keywords" content="{{$field['cate_keywords']}}" />
    <meta name="description" content="{{$field['cate_description']}}" />
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>{{$field['cate_title']}}</span><a href="{{url('/')}}" class="n1">Home</a><a href="{{url('category/'. $field['cate_id'])}}" class="n2">{{$field['cate_name']}}</a></h1>
        <div class="newblog left">
            @foreach($art as $value)
                <h2>{{$value['art_title']}}</h2>
                <p class="dateview"><span>　{{date('Y/m/d',$value['art_time'])}}</span><span>Author：{{$value['art_editor']}}</span><span>Category：[<a href="{{url('category/'.$field['cate_id'])}}">{{$field['cate_name']}}</a>]</span></p>
                <figure><img src="{{url($value['art_thumb']==null? $data['config']['default_picture']:$value['art_thumb'])}}"></figure>
                <ul class="nlist">
                    <p>{{$value['art_description']}}</p>
                    <a title="{{$value['art_id']}}" href="{{url('article/'.$value['art_id'])}}" target="_blank" class="readmore">read more>></a>
                </ul>
                <div class="line"></div>
            @endforeach
            <div class="blank"></div>
            {{--<div class="ad">--}}
                {{--<img src="images/ad.png">--}}
            {{--</div>--}}
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
            <div class="news" style="float: left;">
             @parent
            </div>
        </aside>
    </article>
@endsection
