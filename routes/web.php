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

/**
 * 登录验证
 */
Auth::routes();

Route::get('/', 'HomeController@login');

/*Route::get('test/permissions', 'TestController@insert_to_permissions');*/

Route::group(['middleware' => 'auth'], function() {
    /**
     * 运营人员
     */
    Route::get('business', 'BusinessController@index');
    Route::get('business/create', 'BusinessController@create');
    Route::post('business/store', 'BusinessController@store');
    Route::get('business/show/{id}', 'BusinessController@show');
    Route::get('business/{id}/edit', 'BusinessController@edit');
    Route::put('business/{id}', 'BusinessController@update');
    Route::delete('business/{id}', 'BusinessController@destroy');

    Route::get('business/stat/{id}', 'BusinessController@stat');

    Route::get('business/config', 'BusinessConfigController@index');
    Route::get('business/toconfig/{id}', 'BusinessConfigController@toConfig');
    Route::post('business/config/store', 'BusinessConfigController@store');
    Route::get('business/config/list', 'BusinessConfigController@lists');
    Route::get('business/config/detail/{id}', 'BusinessConfigController@detail');
    Route::get('business/configured', 'BusinessConfigController@configured');
    Route::get('business/config/info/{id}', 'BusinessConfigController@info');
    Route::get('business/config/search', 'BusinessConfigController@search_name');

    Route::get('task/show/{id}', 'TaskController@show');
    Route::put('task/{id}', 'TaskController@update');
    Route::put('task/stop/{id}', 'TaskController@stop');
    Route::get('task/add/{id}', 'TaskController@add');

    Route::get('stat/show/{id}', 'StatController@show');
    Route::put('stat/{id}', 'StatController@update');

    /**
     * 执行人员
     */
    Route::get('task', 'TaskController@index');
    Route::get('task/executing', 'TaskController@executing');
    Route::get('task/revised', 'TaskController@revised');
    Route::get('task/needstop', 'TaskController@needstop');
    Route::get('task/stat', 'TaskController@stat');
    Route::put('task/stop_task/{id}', 'TaskController@stopTask');
    Route::get('task/set_stat/{id}', 'TaskController@setStatTable');
    Route::put('task/exec/{id}', 'TaskController@exec');

    Route::post('stat/get_stats', 'StatController@getStats');
    Route::post('stat/store', 'StatController@store');

    /**
     * 业管人员
     */
    Route::get('business/audit', 'BusinessAuditController@index');
    Route::get('business/pass/{id}', 'BusinessAuditController@auditPass');
    Route::post('business/failed', 'BusinessAuditController@auditFailed');
    Route::get('business/list', 'BusinessAuditController@lists');

    /**
     * 管理后台
     */
    Route::get('/admin/account', 'Admin\AccountController@index');
    Route::get('/admin/account/create', 'Admin\AccountController@create');
    Route::post('/admin/account/store', 'Admin\AccountController@store');
    Route::delete('/admin/account/{id}', 'Admin\AccountController@destroy');
    Route::put('/admin/account/{id}/{status}', 'Admin\AccountController@update');

    Route::get('/admin/media', 'Admin\MediaController@index');
    Route::get('/admin/media/create', 'Admin\MediaController@create');
    Route::post('/admin/media/store', 'Admin\MediaController@store');
    Route::delete('/admin/media/{id}', 'Admin\MediaController@destroy');
    Route::put('/admin/media/{id}/{status}', 'Admin\MediaController@update');
    Route::get('/admin/media/assign', 'Admin\MediaController@assign');
    Route::post('admin/media/doAssign', 'Admin\MediaController@doAssign');
    Route::post('/admin/media/delUser', 'Admin\MediaController@delUser');

    Route::get('admin/user', 'Admin\UserController@index');
    Route::get('admin/user/create', 'Admin\UserController@create');
    Route::post('admin/user/store', 'Admin\UserController@store');

    // Route::get('/home', 'HomeController@index')->name('home');

    /**
     * 管理后台 > 权限管理 > 角色管理
     */
    Route::get('/admin/role', 'Admin\RoleController@index');
    Route::get('/admin/role/create', 'Admin\RoleController@create');
    Route::post('/admin/role/store', 'Admin\RoleController@store');
    Route::get('/admin/role/assign', 'Admin\RoleController@assign');
    Route::post('/admin/role/doAssign', 'Admin\RoleController@doAssign');
    Route::post('/admin/role/removal', 'Admin\RoleController@removal');

    /**
     * 管理后台 > 权限管理 > 权限管理
     */
    Route::get('/admin/permission', 'Admin\PermissionController@index');
    Route::get('/admin/permission/create', 'Admin\PermissionController@create');
    Route::post('/admin/permission/store', 'Admin\PermissionController@store');
    Route::get('/admin/permission/assign', 'Admin\PermissionController@assign');
    Route::post('/admin/permission/doAssign', 'Admin\PermissionController@doAssign');
    Route::post('/admin/permission/removal', 'Admin\PermissionController@removal');
});