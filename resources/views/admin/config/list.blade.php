@extends('layouts.admin')
@section('js')
    @parent
@endsection
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">HOME</a> &raquo;  All Config
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
        <div class="result_wrap">
            <div class="result_title">
                <h3>Config Management</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>Add Config</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-refresh"></i>Refresh Config</a>
                </div>
            </div>
            <!--快捷导航 结束-->
            <div class="result_title">
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_string($errors))
                            <p>{{$errors}}</p>
                        @else
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changecontent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">Sort</th>
                        <th class="tc" width="5%">ID</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Content</th>
                        <th>Operation</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text"  onchange="changeOrder(this,'{{$v['conf_id']}}')" value="{{$v['conf_order']}}">
                        </td>
                        <td class="tc">{{$v['conf_id']}}</td>
                        <td>
                            <a href="#">{{$v['conf_title']}}</a>
                        </td>
                        <td>{{$v['conf_name']}}</td>
                            <input type="hidden" name="conf_id[]" value="{{$v['conf_id']}}">
                            <td>{!! $v['_html'] !!}</td>
                        <td>
                            <a href="{{url('admin/config/'.$v['conf_id'].'/edit')}}">EDIT</a>
                            <a href="javascript:;" onclick="deleteConfirm({{$v['conf_id']}})">DELETE</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="btn_group">
                    <input type="submit" value="SUBMIT">
                    <input type="button" class="back" onclick="history.go(-1)" value="BACK" >
                </div>
                </form>


                {{--<div class="page_nav">
                    <div>
                        <a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>
                        <a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
                        <span class="current">8</span>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>
                        <a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>
                        <a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>
                        <span class="rows">11 条记录</span>
                    </div>
                </div>



                <div class="page_list">
                    <ul>
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>--}}
            </div>
        </div>

    <!--搜索结果页面 列表 结束-->
    <script>
        // use jquery ang ajax to request without refreshing the current page
        function changeOrder(object, sID) {
            var order = $(object).val();
            $.post("{{url('admin/config/changeorder')}}",
                {'_token':'{{csrf_token()}}','conf_id':sID, 'conf_order':order},
                function (aData) {
                   if (aData.status){
                       layer.msg(aData.msg, {icon: 6});
                   }else{
                       layer.msg(aData.msg, {icon: 5});
                   }
                }
            );
        }
        //询问框
        function deleteConfirm(sConf_id){
            layer.confirm('Are you sure？', {
                btn: ['Yes','No'] //按钮
            }, function(){
                $.post("{{url('admin/config')}}/"+ sConf_id,
                    {'_method':'delete','_token':'{{csrf_token()}}'},
                function (aData){
                    if (aData.status){
                        layer.msg(aData.msg, {icon: 6});
                        location.href = location.href;// refresh after deleting
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
