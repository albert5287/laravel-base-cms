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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', 'HomeController@index');

// Authentication routes...
Route::get('login', [
    'uses' => 'Auth\AuthController@getLogin',
    'as' => 'login'
]);
Route::post('login', [
    'uses' => 'Auth\AuthController@postLogin',
    'as' =>'postLogin'
]);
Route::get('logout', [
    'uses' => 'Auth\AuthController@getLogout',
    'as' => 'logout'
]);
// Registration routes...
Route::get('register', [
    'uses' => 'Auth\AuthController@getRegister',
    'as' => 'register'
]);
Route::post('register', [
    'uses' => 'Auth\AuthController@postRegister',
    'as' => 'postRegister'
]);


// Password reset link request routes...
Route::get('password/email', [
    'uses' => 'Auth\PasswordController@getEmail',
    'as' => 'password/email'
]);
Route::post('password/email', [
    'uses' => 'Auth\PasswordController@postEmail',
    'as' => 'password/postEmail'
]);

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', [
    'uses' =>  'Auth\PasswordController@postReset',
    'as' => 'password/postReset'
]);

Route::get('change-current-app/{appId}', 'HomeController@changeCurrentApp');

//create routes for the active modules
//users
Route::any('apps/users/{app_id}/data', 'UserController@data');
Route::post('users/{app_id}', 'UserController@store');
Route::get('apps/users/{app_id}', 'UserController@index'); //list of a content module
Route::get('apps/users/create/{app_id}', 'UserController@create');
Route::get('apps/users/{users}/edit/{app_id}', 'UserController@edit');
Route::delete('apps/users/{users}/{app_id}', 'UserController@destroy');
Route::match(['put', 'patch'], 'apps/users/{users}/{app_id}', 'UserController@update');
//roles
Route::any('apps/roles/{app_id}/data', 'RoleController@data');
Route::post('roles/{app_id}', 'RoleController@store');
Route::get('apps/roles/{app_id}', 'RoleController@index'); //list of a content module
Route::get('apps/roles/create/{app_id}', 'RoleController@create');
Route::get('apps/roles/{roles}/edit/{app_id}', 'RoleController@edit');
Route::delete('apps/roles/{roles}', 'RoleController@destroy');
Route::match(['put', 'patch'], 'roles/{roles}/{app_id}', 'RoleController@update');
foreach(getAllActiveModules() as $module){
    if($module->name !== 'users' && $module->name !== 'roles') {
        if ($module->is_content_module) {
            Route::any($module->name . '/{module_application_id}/data', $module->class . 'Controller@data');
            Route::post($module->name, $module->class . 'Controller@store');
            Route::get($module->name . '/{module_application_id}',
                $module->class . 'Controller@index'); //list of a content module
            Route::get($module->name . '/create/{module_application_id}', $module->class . 'Controller@create');
            Route::get($module->name . '/{' . $module->name . '}/edit/{module_application_id}',
                $module->class . 'Controller@edit');
            Route::delete($module->name . '/{' . $module->name . '}', $module->class . 'Controller@destroy');
            Route::match(['put', 'patch'], $module->name . '/{' . $module->name . '}',
                $module->class . 'Controller@update');
        } else {
            Route::any($module->name . '/data', $module->class . 'Controller@data');
            Route::resource($module->name, $module->class . 'Controller');
        }
    }
}
Route::get('content', 'ContentController@index');

