@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">Home</a> &raquo; Add New Config
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>Config Management</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>Config List</a>
           {{-- <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
            <a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
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
    <form action="{{url('admin/config')}}" method="post">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i>TITLE：</th>
                <td>
                    <input type="text" name="conf_title">
                    <span><i class="fa fa-exclamation-circle yellow"></i>Title must not be empty</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>NAME：</th>
                <td>
                    <input type="text" name="conf_name">
                    <span><i class="fa fa-exclamation-circle yellow"></i>Name must not be empty</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>TYPE：</th>
                <td>
                    <input type="radio"  name="field_type" value="input" checked onclick="showValue()"> input　　
                    <input type="radio"  name="field_type" value="textarea" onclick="showValue()"> textarea　　
                    <input type="radio"  name="field_type" value="radio" onclick="showValue()"> radio　　
                </td>
            </tr>
            <tr class="radioValue" hidden>
                <th><i class="require">*</i>VALUE：</th>
                <td>
                    <lable>0 : </lable><input type="text" class="md" name="field_value_0"><br>
                    <lable>1 : </lable><input type="text" class="md" name="field_value_1">
                    <p><i class="fa fa-exclamation-circle yellow"></i>The Meaning of Radio Value, Like -- 0 : OFF | 1 : ON</p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>CONTENT：</th>
                <td>
                    <textarea name="conf_content" id="" cols="30" rows="10"></textarea>
                </td>
            </tr>
            <tr>
                <th>SORT：</th>
                <td>
                    <input type="text" class="sm" name="conf_order" value="0">
                </td>
            </tr>
            <tr>
                <th>NOTES：</th>
                <td>
                    <textarea name="conf_tips" id="" cols="30" rows="10" ></textarea>
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
<script>
    function showValue(){
        var sTypeValue = $('input[name=field_type]:checked').val();
        var oRadioValue =  $('.radioValue');
        if (sTypeValue == 'radio'){
            oRadioValue.show();
        }else{
            oRadioValue.hide();
        }
    }
</script>
@endsection
