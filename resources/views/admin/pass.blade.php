@extends('layouts.admin')
@section('js')
@parent
@endsection
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">Home</a> &raquo; Change Password
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>Change Password</h3>
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
        <form method="post" action="" >
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="160"><i class="require">*</i>Old Password：</th>
                    <td>
                        <input type="password" name="password_o"> </i>input the old password</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>New Password：</th>
                    <td>
                        <input type="password" name="password"> </i>new password: 6-20 bits</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>Confirm Password：</th>
                    <td>
                        <input type="password" name="password_confirmation"> </i>input the new password again</span>
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
