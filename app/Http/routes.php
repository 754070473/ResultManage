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
Route::get('/examine','GradeController@examine');
//成绩管理---成绩理论、机试修改

//成绩管理---成绩审核分页
Route::get('/examinePage','GradeController@examinePage');
//成绩管理---成绩审核
Route::get('/examineInfo','GradeController@examineInfo');
Route::get('/updatess','GradeController@updatess');
//成绩管理---导入
Route::any('/import','GradeController@import');
//成绩管理---删除

Route::get('/gradeDelete','GradeController@gradeDelete');
//成绩管理---分页
Route::get('/gradePage','GradeController@gradePage');
//成绩管理---搜索

/**80-100 刘清白用户管理**/
//用户管理-添加表单
Route::get('/useradd', 'UserController@userAdd');
//用户管理-ajax添加用户
Route::post('/useraddpro', 'UserController@userAddPro');

//用户管理-用户列表表单
Route::get('/userList', 'UserControllr@userList');
//用户管理-表格内容  ajax post
Route::any('/userListInfo', 'UserController@userListInfo');
//用户管理-ajax修改
Route::any('/userListUpdate', 'UserController@userListUpdate');
//用户管理-ajax修改放入回收站
Route::any('/logDelete', 'UserController@logDelete');
//用户管理-ajax修改修改角色
Route::any('/roleUpdate', 'UserController@roleUpdate');
//用户管理-回收站
Route::any('/userRemove', 'UserController@userRemove');
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
//学院首页
Route::get('collShow', 'GroupController@groupShow');
//创建学院
Route::get('collAdd','GroupController@groupCollAdd');
//创建班级
Route::get('claAdd','GroupController@groupClaAdd');
//班级表单
Route::get('groupClaShow','GroupController@groupClaShow');


