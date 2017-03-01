@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">Home</a> &raquo; Edit Navigation
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>Navigation Management</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>Add Navigation</a>
            <a href="{{url('admin/nav')}}"><i class="fa fa-recycle"></i>Navigation List</a>
        </div>
    </div>
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
<!--结果集标题与导航组件 结束-->
<div class="result_wrap">
    <form action="{{url('admin/nav/'.$field['nav_id'])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i>NAME：</th>
                <td>
                    <input type="text" name="nav_name" value="{{$field['nav_name']}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>Name must not be empty</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>Alias：</th>
                <td>
                    <input type="text" class="sm" name="nav_alias" value="{{$field['nav_alias']}}" >
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>WEBSITE：</th>
                <td>
                    <input type="text" class="lg" name="nav_url" value="{{$field['nav_url']}}">
                </td>
            </tr>
            <tr>
                <th>SORT：</th>
                <td>
                    <input type="text" class="sm" name="nav_order" value="{{$field['nav_order']}}">
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="SUBMIT">
                    <input type="button" class="back" onclick="history.go(-1)" value="BACK">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection
