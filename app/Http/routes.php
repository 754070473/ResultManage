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
//日志删除
Route::get('/logDelete', 'IndexController@logDelete');












//成绩管理---显示录入成绩页面
Route::get('/grade','GradeController@grade');
//成绩管理---添加录入成绩数据
Route::get('/grade_add','GradeController@grade_add');
//成绩管理----查看成绩
Route::get('/show','GradeController@show');
//成绩管理---成绩修改
Route::get('/updates','GradeController@updates');
Route::get('/updatess','GradeController@updatess');
//成绩管理---导入
Route::get('/import','GradeController@import');
//成绩管理---删除
Route::get('/gradeDelete','GradeController@gradeDelete');
//成绩管理---分页
Route::get('/gradePage','GradeController@gradePage');
//成绩管理---搜索
Route::get('/search','GradeController@search');
