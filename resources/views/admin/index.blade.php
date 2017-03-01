@extends('layouts.admin')
@section('js')
@parent
@endsection
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">MANAGEMENT</div>
			<ul>
				<li><a href="{{url('admin/info')}}"  target="main" class="active">Management</a></li>
				<li><a href="{{url('/')}}" target="_blank">Home</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>Admin：{{session('user')->user_name}}</li>
				<li><a href="{{url('admin/pass')}}" target="main">Password</a></li>
				<li><a href="{{url('admin/quit')}}">Quit</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>Management</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>Add Category</a></li>
					<li><a href="{{url('admin/category')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>Category List</a></li>
					<li><a href="{{url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-list-alt"></i>Add Article</a></li>
					<li><a href="{{url('admin/article')}}" target="main"><i class="fa fa-fw fa-image"></i>Article List</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-cog"></i>System Setting</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/link')}}" target="main"><i class="fa fa-fw fa-cubes"></i>Link List</a></li>
					<li><a href="{{url('admin/nav')}}" target="main"><i class="fa fa-fw fa-navicon"></i>Nav List</a></li>
					<li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-cogs"></i>Config List</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2017. Powered By su <a href="#">http://www.</a>.
	</div>
	<!--底部 结束-->
@endsection

