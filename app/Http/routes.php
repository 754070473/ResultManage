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
Route::get('/index', 'IndexController@index');
Route::get('/', 'IndexController@index');


//登录页
Route::any('/loginIndex', 'LoginController@index');
//登录
Route::any('/login', 'LoginController@login');
//验证码
Route::any('/captcha_code', 'LoginController@captcha_code');
//退出
Route::any('/exitProcess', 'LoginController@exitProcess');
//修改密码页面
Route::any('/pass', 'LoginController@pass');
//查询旧密码
Route::any('/oldpwd', 'LoginController@oldpwd');
//修改密码
Route::any('/upda', 'LoginController@update_pwd');

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
//成绩管理---成绩审核
Route::get('/updates','GradeController@updates');
//成绩管理---导入
Route::get('/import','GradeController@import');
//成绩管理---删除
Route::get('/updates','GradeController@updates');

/**80-100 刘清白**/
//用户添加表单
Route::get('/useradd', 'UserController@userAdd');
//ajax添加用户
Route::post('/useraddpro', 'UserController@userAddPro');
//用户列表
Route::get('/userList', 'UserController@userList');
