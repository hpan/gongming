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

Route::get('now', function () {
    return date("Y-m-d H:i:s");
});

Route::auth();

Route::get('/', 'HomeController@index');
//Route::get('article/create', 'ArticleController@create');
//Route::get('article/{id}', 'ArticleController@show');
Route::post('comment', 'CommentController@store');


Route::post('file/upload', 'FileController@upload');
Route::get('file/show/{filename}', 'FileController@show');
Route::get('article/success', 'ArticleController@success');
Route::get('article/create2', 'ArticleController@create2');
Route::any('wechat', 'WechatController@serve');
Route::any('wechat/menu', 'WechatController@menu');
Route::any('wechat/createmenu', 'WechatController@createmenu');
Route::any('wechat/send', 'WechatController@send');
Route::any('wechat/oauth_callback', 'WechatController@oauth_callback');
Route::any('test/{id}', 'TestController@show');
Route::resource('article', 'ArticleController');
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'HomeController@index');
    Route::resource('article', 'ArticleController');
    Route::resource('feedback', 'FeedbackController');
    Route::post('comment', 'CommentController@store');
    Route::get('comment/{id}', 'CommentController@get');
});
Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料

        dd($user);
    });
});