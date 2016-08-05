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
Route::get('/roleadd','RoleController@roleAdd');            //角色名的验证
Route::post('/roleins','RoleController@roleIns');           //角色的添加
Route::get('/rolelist','RoleController@roleList');          //角色的列表
Route::get('/rolelists','RoleController@rolePage');         //角色列表的分页
Route::get('/rolestatus','RoleController@roleStatus');      //角色的状态修改
Route::get('/roleupdate','RoleController@roleUpd');         //角色名称的修改
Route::post('/roleupdates','RoleController@roleUpdate');    //角色名修改页面
Route::get('/roledelete','RoleController@roleDelete');      //删除角色时的验证
Route::get('/roledel','RoleController@roleDel');            //删除角色
Route::get('/rolegive','RoleController@roleGive');          //角色赋权页面
Route::get('/rolegives','RoleController@roleGives');        //修改角色的权限
