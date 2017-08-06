<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$router = app('Dingo\Api\Routing\Router');
//'middleware'=>'api.auth',
$router->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function ($api) {

    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('/register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@store']);
        $api->post('/token', ['as' => 'auth.token', 'uses' => 'Auth\TokenController@authenticate']);

        $api->group(['prefix' => 'password', 'middleware' => 'api.auth'], function ($api) {
            $api->post('/reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@reset']);
        });

        $api->group(['prefix' => 'password'], function ($api) {
            $api->post('/forget', ['as' => 'password.forget', 'uses' => 'Auth\PasswordController@forget']);
            $api->post('/set', ['as' => 'password.set', 'uses' => 'Auth\PasswordController@set']);

        });

    });

    $api->group(['prefix' => 'profile', 'middleware' => 'api.auth'], function ($api) {
        $api->get('/points', ['as' => 'profile.points', 'uses' => 'ProfileController@points']);

        $api->get('', ['as' => 'profile.show', 'uses' => 'ProfileController@show']);
        $api->put('', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

    });
    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->resource('users', 'UserController');
        $api->resource('roles', 'RoleController');
    });

});