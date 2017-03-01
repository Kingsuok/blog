@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">HOME</a> &raquo; System Information
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>Shortcut Operations</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>Add Article</a>
                <a href="{{url('admin/category/create')}}"><i class="fa fa-recycle"></i>Add Category</a>

            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->


    <div class="result_wrap">
        <div class="result_title">
            <h3>System Info</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>OS</label><span>{{PHP_OS}}</span>
                </li>
                <li>
                    <label>Operating environment</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                </li>
                <li>
                    <label>PHP Running Mode</label><span>apache2handler</span>
                </li>
                <li>
                    <label>Version</label><span>v-1.0</span>
                </li>
                <li>
                    <label>Upload Restrictions</label><span>{{get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"no upload attachment"}}</span>
                </li>
                <li>
                    <label>Toroto time</label><span>{{date("Y-m-d G:i:s")}}</span>
                </li>
                <li>
                    <label>Server Domain Name/IP</label><span>{{$_SERVER['SERVER_NAME']}} [{{$_SERVER['SERVER_ADDR']}}]</span>
                </li>
                <li>
                    <label>Host</label><span>{{$_SERVER['SERVER_ADDR']}}</span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>Help</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>Communication：</label><span><a href="#"></a></span>
                </li>
                <li>
                    <label>QQ Group：</label><span><a href="#"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png"></a></span>
                </li>
            </ul>
        </div>
    </div>
    <!--结果集列表组件 结束-->
        @endsection




