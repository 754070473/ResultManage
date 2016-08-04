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








//角色页面
Route::get('/roleadd','RoleController@roleAdd');
Route::post('/roleins','RoleController@roleIns');
Route::get('/rolelist','RoleController@roleList');
Route::post('/roleupdate','RoleController@roleUpd');
Route::post('/roleupdates','RoleController@roleUpdate');
Route::post('/roledelete','RoleController@roleDelete');
Route::post('/roledel','RoleController@roleDel');
