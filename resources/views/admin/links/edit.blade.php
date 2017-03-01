@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">Home</a> &raquo; Edit Link
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>Link Management</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>Add Link</a>
            <a href="{{url('admin/link')}}"><i class="fa fa-recycle"></i>Link List</a>
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
    <form action="{{url('admin/link/'.$field['link_id'])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i>NAME：</th>
                <td>
                    <input type="text" name="link_name" value="{{$field['link_name']}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>Name must not be empty</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>WEBSITE：</th>
                <td>
                    <input type="text" class="lg" name="link_url" value="{{$field['link_url']}}">
                </td>
            </tr>
            <tr>
                <th>SLOGAN：</th>
                <td>
                    <input type="text" class="lg" name="link_description" value="{{$field['link_description']}}">
                </td>
            </tr>
            <tr>
                <th>SORT：</th>
                <td>
                    <input type="text" class="sm" name="link_order" value="{{$field['link_order']}}">
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
