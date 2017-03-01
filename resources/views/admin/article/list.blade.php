@extends('layouts.admin')
@section('js')
    @parent
@endsection
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">HOME</a> &raquo;  All Articles
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
{{--    <div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
        </div>--}}
    <!--结果页快捷搜索框 结束-->
    <!--搜索结果页面 列表 开始-->

    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>Article Management</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>Add Article</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">ID</th>
                        <th>Title</th>
                        <th>View</th>
                        <th>Editor</th>
                        <th>Date</th>
                        <th>Operation</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v['art_id']}}</td>
                        <td>
                            <a href="#">{{$v['art_title']}}</a>
                        </td>
                        <td>{{$v['art_view']}}</td>
                        <td>{{$v['art_editor']}}</td>
                        <td>{{date('Y-m-d',$v['art_time'])}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$v['art_id'].'/edit')}}">EDIT</a>
                            <a href="javascript:;" onclick="deleteConfirm({{$v['art_id']}})">DELETE</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    <style>
                        .result_content ul li span {
                            font-size: 15px;
                            padding: 6px 12px;
                        }
                    </style>
                   {{$data->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        // use jquery ang ajax to request without refreshing the current page
        //询问框
        function deleteConfirm(sArt_id){
            layer.confirm('Are you sure？', {
                btn: ['Yes','No'] //按钮
            }, function(){
                $.post("{{url('admin/article')}}/"+sArt_id,
                    {'_method':'delete','_token':'{{csrf_token()}}'},
                function (aData){
                    if (aData.status){
                        layer.msg(aData.msg, {icon: 6});
                        // refresh current page with parameter,
                        // do not use location.reload() which can not transmit parameter
                        location.href = location.href;
                    }else{
                        layer.msg(aData.msg, {icon: 5});
                    }
                });
                //layer.msg('的确很重要', {icon: 1});
            }, function(){
            });
        }
    </script>
@endsection
