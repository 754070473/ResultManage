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




























































/**80-100 刘清白**/
//用户添加表单
Route::get('/useradd', 'UserController@userAdd');
//ajax添加用户
Route::post('/useraddpro', 'UserController@userAddPro');
//用户列表
Route::get('/userList', 'UserController@userList');
