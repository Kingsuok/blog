@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">Home</a> &raquo; Edit Article
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>Article Management</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>Add Article</a>
            <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>Article List</a>
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
    <form action="{{url('admin/article/'.$field['art_id'])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="180"><i class="require">*</i>CATEGORY：</th>
                <td>
                    <select name="art_cat">
                        <option value="">== SELECT ==</option>
                        @foreach($data as $v)
                        <option value="{{$v['cate_id']}}"
                        @if($field['art_cat'] == $v['cate_id'])
                            selected
                        @endif
                        >{{str_repeat('&nbsp;&nbsp;',$v['level']*2).$v['cate_name']}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th><i class="require">*</i>TITLE：</th>
                <td>
                    <input type="text" class="lg" name="art_title" value="{{$field['art_title']}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>EDITOR：</th>
                <td>
                    <input type="text" name="art_editor" value="{{$field['art_editor']}}">
                </td>
            </tr>
            <tr>
                <th>THUMB：</th>
                <td>
                    <input type="text" class="lg" name="art_thumb" disabled value="{{$field['art_thumb']}}">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <img id="art_thumb_img"  style="max-width: 350px; max-height: 100px;" src="{{$field['art_thumb'] != null? url($field['art_thumb']):''}}">
                    <script src="{{url('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                    <link rel="stylesheet" type="text/css" href="{{url('resources/org/uploadify/uploadify.css')}}">
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        $(function() {
                            $('#file_upload').uploadify({
                                'formData'     : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : "{{csrf_token()}}"
                                },
                                'swf'      : "{{url('resources/org/uploadify/uploadify.swf')}}",
                                'uploader' : "{{url('admin/upload')}}",
                                'onUploadSuccess' : function(file, data, response) {
                                    data = JSON.parse(data);// data is string
                                    if (data.status){
                                        layer.msg(data.msg, {icon: 6});
                                        $('input[name=art_thumb]').val(data.filePath);
                                        $('#art_thumb_img').attr('src',"{{url('/')}}" + '/' + data.filePath);
                                    }else{
                                        layer.msg(data.msg, {icon: 5});
                                    }
                                }
                            });
                        });
                    </script>
                    <style>
                        .uploadify{display:inline-block;}
                        .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                        table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                    </style>
                </td>
            </tr>
            <tr>
                <th>KEY WORDS：</th>
                <td>
                    <input type="text" class="lg" name="art_tag" value="{{$field['art_tag']}}">
                </td>
            </tr>
            <tr>
                <th>DESCRIPTION：</th>
                <td>
                    <textarea name="art_description">{{$field['art_description']}}</textarea>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>CONTENT：</th>
                <td>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/UEditor/ueditor.config.js')}}"></script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/UEditor/ueditor.all.min.js')}}"> </script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/UEditor/lang/en/en.js')}}"></script>
                    <script id="editor" name="art_content" type="text/plain" style="width:850px;height:500px;">{!! $field['art_content'] !!}</script>
                    <script>
                        var ue = UE.getEditor('editor');
                    </script>
                    <style>
                        .edui-default{line-height: 28px;}
                        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                        {overflow: hidden; height:20px;}
                        div.edui-box{overflow: hidden; height:22px;}
                    </style>
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
