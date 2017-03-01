
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('title')
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($data['navs'] as $nav)<a href="{{$nav['nav_url']}}"target="_blank"><span>{{$nav['nav_name']}}</span><span class="en">{{$nav['nav_alias']}}</span></a>@endforeach
    </nav>
</header>

@section('content')
    <h3>
        <p><span>Latest</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $value)
            <li><a href="{{url('a/'.$value['art_id'])}}" title="{{$value['art_title']}}" target="_blank">{{$value['art_title']}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p><span>Rank</span></p>
    </h3>
    <ul class="paih">
        @for($i = 0; $i < 5; ++$i)
            @if($i<6)
                <li><a href="{{url('a/'.$hot[$i]['art_id'])}}" title="{{$hot[$i]['art_title']}}" target="_blank">{{$hot[$i]['art_title']}}</a></li>
            @endif
        @endfor
    </ul>
@show

<footer>
    <p>{!! $data['config']['copyright'] !!} {!! $data['config']['code_statistics'] !!}</a>
    </p>
</footer>
{{--<script src="{{asset('resources/views/home/js/silder.js')}}"></script>--}}
</body>
</html>
