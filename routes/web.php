<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// The front-edn routes
//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['namespace'=>'home'],function (){
    Route::get('/','IndexController@index');
    Route::get('/category/{cate_id}','IndexController@category');
    Route::get('/article/{art_id}','IndexController@article');
});

// The below routes are back-end routes
Route::any('/admin/login', 'Admin\LoginController@login');
Route::get('/admin/code', 'Admin\LoginController@code');

Route::group(['middleware'=>['admin.login'], 'prefix'=>'admin', 'namespace'=>'Admin'], function (){
    Route::get('/', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');
    Route::post('category/changeorder','CategoryController@changeOrder');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');

    Route::post('upload','CommonController@upload');

    Route::post('link/changeorder','LinksController@changeOrder');
    Route::resource('link','LinksController');

    Route::post('nav/changeorder','NavsController@changeOrder');
    Route::resource('nav','NavsController');
   // 同一个Controller的route， 另外添加的route一定要放到resource route 之前，以免冲突
    Route::post('config/changeorder','ConfigController@changeOrder');
    Route::post('config/changecontent','ConfigController@changeContent');
    Route::get('config/writefile','ConfigController@writeFile');
    Route::resource('config','ConfigController');
});

