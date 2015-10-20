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

Route::get('news/{module_application_id}', 'NewsController@index');

//create routes for the active modules
foreach(getActiveModules() as $module){
    Route::resource($module->name, $module->class.'Controller');
}
Route::get('content', 'ContentController@index');
