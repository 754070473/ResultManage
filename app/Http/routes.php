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







































//角色页面
Route::get('/roleadd','RoleController@roleAdd');
Route::post('/roleins','RoleController@roleIns');
Route::get('/rolelist','RoleController@roleList');
Route::post('/roleupdate','RoleController@roleUpd');
Route::post('/roleupdates','RoleController@roleUpdate');
Route::post('/roledelete','RoleController@roleDelete');
Route::post('/roledel','RoleController@roleDel');
