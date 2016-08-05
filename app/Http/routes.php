<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//首页
Route::get('/', 'IndexController@index');
Route::get('/index', 'IndexController@index');

//公共页面  头部
Route::get('/top', 'PublicController@top');
//公共页面  左侧导航
Route::get('/left', 'PublicController@left');

//管理员日志
Route::get('/userlog', 'IndexController@userLog');
//日志分页
Route::get('/logPage', 'IndexController@logPage');


















































































































//学院首页
Route::get('collShow', 'GroupController@groupShow');
//创建学院
Route::get('collAdd','GroupController@groupCollAdd');
//创建班级
Route::get('claAdd','GroupController@groupClaAdd');
//班级表单
Route::get('groupClaShow','GroupController@groupClaShow');



