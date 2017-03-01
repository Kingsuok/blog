@extends('layouts.home')
@section('title')
    <title>{{$field['art_title']}} -- {{$data['config']['web_title']}}}</title>
    <meta name="keywords" content="{{$field['art_tag']}}" />
    <meta name="description" content="{{$field['art_description']}}" />
@endsection
@section('content')
    <article class="blogs">
        <h1 ><a href="{{url('/')}}" class="n1">Home</a><a href="{{url('category/'.$field['art_cat'])}}" class="n2">{{$field['cate_name']}}</a><span style="float: right;"  >Location：<a href="{{url('/')}}">Home</a>@foreach($tree as $cate)&nbsp;&gt;&nbsp;<a href="{{url('category/'.$cate['cate_id'])}}">{{$cate['cate_name']}}</a>@endforeach</span></h1>
        <div class="index_about">
            <h2 class="c_titile">{{$field['art_title']}}</h2>
            <p class="box_c"><span class="d_time"> {{date('Y/m/d',$field['art_time'])}}</span><span>by：{{$field['art_editor']}}</span><span>browse：{{$field['art_view']}}</span></p>
            <ul class="infos">
                <p style="float: left">
                    <img style="max-width: 700px; max-height: 300px; margin-right: 10px;"  src="{{url($field['art_thumb']==null? $data['config']['default_picture']:$field['art_thumb'])}}" alt="">
                    {!! $field['art_content'] !!}
                </p>

            </ul>
            <div class="keybq">
                <p><span>keywords</span>：{{$field['art_tag']}}</p>

            </div>
            <div class="ad"> </div>
            <div class="nextinfo">
                @if($article['prior'])
                    <p>Prior：<a href="{{url('article/'.$article['prior']['art_id'])}}">{{$article['prior']['art_title']}}</a></p>
                @endif
                @if($article['next'])
                <p>Next：<a href="{{url('article/'.$article['next']['art_id'])}}">{{$article['next']['art_title']}}</a></p>
                @endif
            </div>
            <div class="otherlink">
                <h2>相关文章</h2>
                <ul>
                    @foreach($related as $value)
                        <li><a href="{{url('article/'.$value['art_id'])}}" title="{{$value['art_title']}}">{{$value['art_title']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <aside class="right">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="blank"></div>
            <div class="news">
                @parent
            </div>
            {{--<div class="visitors">--}}
                {{--<h3>--}}
                    {{--<p>最近访客</p>--}}
                {{--</h3>--}}
                {{--<ul>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </aside>
    </article>
@endsection
