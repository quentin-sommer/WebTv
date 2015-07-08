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

/*
 * public
 */
$app->group(['namespace' => 'App\Http\Controllers'], function ($group) use ($app) {

    $app->get('/', [
        'as'   => 'getIndex',
        'uses' => 'MainController@getMain'
    ]);
    $app->get('streams', [
        'as'   => 'streams',
        'uses' => 'StreamController@getAll'
    ]);
    $app->get('stream/search', [
        'as'   => 'streamSearch',
        'uses' => 'StreamController@streamSearch'
    ]);
    $app->get('stream/{streamerName}', [
        'as'   => 'getStream',
        'uses' => 'StreamController@getStream'
    ]);
    $app->get('calendar', [
        'as'   => 'getCalendar',
        'uses' => 'CalendarController@getCalendar'
    ]);
    $app->get('calendar/events', [
        'as'   => 'getCalEvents',
        'uses' => 'CalendarController@getCalEvents'
    ]);
});
/*
 * Guest only
 */
$app->group(['namespace' => 'App\Http\Controllers', 'middleware' => 'guest'], function ($app) {

    $app->get('login', [
        'as'   => 'getLogin',
        'uses' => 'UserController@getLogin'
    ]);
    $app->post('login', [
        'as'   => 'postLogin',
        'uses' => 'UserController@postLogin'
    ]);
    $app->get('register', [
        'as'   => 'getRegister',
        'uses' => 'UserController@getRegister'
    ]);
    $app->post('register', [
        'as'   => 'postRegister',
        'uses' => 'UserController@postRegister'
    ]);
});
/*
 * Auth only
 */
$app->group(['namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function ($app) {

    $app->get('profile', [
        'as'   => 'getProfile',
        'uses' => 'UserController@getProfile'
    ]);
    $app->post('profile', [
        'as'   => 'postProfile',
        'uses' => 'UserController@postProfile'
    ]);
    $app->get('logout', [
        'as'   => 'logout',
        'uses' => 'UserController@logout'
    ]);
    $app->post('stream/experience/startWatching', [
        'as'   => 'startWatching',
        'uses' => 'StreamController@startWatching'
    ]);
    $app->post('stream/experience/update', [
        'as'   => 'updateWatching',
        'uses' => 'StreamController@updateWatching'
    ]);
    $app->get('avatar/delete', [
       'as'=>'deleteAvatar',
       'uses'=>'UserController@deleteAvatar'
    ]);
});
/*
 * Admin only
 */
$app->group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers', 'middleware' => 'admin'], function ($app) {

    $app->get('', [
        'as'   => 'getAdminDashboard',
        'uses' => 'AdminController@getDashboard'
    ]);
    $app->post('', [
        'as'   => 'postAdminDashboard',
        'uses' => 'AdminController@postDashboard'
    ]);
    $app->get('users', [
        'as'   => 'getUserSettings',
        'uses' => 'AdminController@getUserSettings'
    ]);
    $app->post('users', [
        'as'   => 'postUserSettings',
        'uses' => 'AdminController@postUserSettings'
    ]);
    $app->post('users/delete/{id}', [
        'as'   => 'postDeleteUser',
        'uses' => 'AdminController@postDeleteUser'
    ]);
    $app->post('calendar/addEvent', [
        'as'   => 'calendarAddEvent',
        'uses' => 'CalendarController@addEvent'
    ]);
    $app->post('calendar/edit', [
        'as'   => 'calendarEdit',
        'uses' => 'CalendarController@editCalendar'
    ]);
});