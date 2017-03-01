@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">Home</a> &raquo; Edit Category
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>Category Management</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>Add Category</a>
            <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>Category List</a>
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
    <form action="{{url('admin/category/'.$field['cate_id'])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="180"><i class="require">*</i>PARENT CATEGORY：</th>
                <td>
                    <select name="cate_pid">
                        <option value="0">=Top Category=</option>
                        @foreach($data as $v)
                        <option value="{{$v['cate_id']}}"
                                @if($v['cate_id'] == $field['cate_pid'])
                                    selected
                                @endif
                        >{{$v['cate_name']}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>CATEGORY NAME：</th>
                <td>
                    <input type="text" name="cate_name" value="{{$field['cate_name']}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>Name must not be empty</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>CATEGORY TITLE：</th>
                <td>
                    <input type="text" class="lg" name="cate_title" value="{{$field['cate_title']}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>KEY WORDS：</th>
                <td>
                    <input type="text" class="lg" name="cate_keywords" value="{{$field['cate_keywords']}}">
                </td>
            </tr>
            <tr>
                <th>DESCRIPTION：</th>
                <td>
                    <textarea name="cate_description">{{$field['cate_name']}}</textarea>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>SORT：</th>
                <td>
                    <input type="text" class="sm" name="cate_order" value="{{$field['cate_order']}}">
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
