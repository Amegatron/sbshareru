<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', "IndexController@getIndex");

Route::controller('index', 'IndexController');
Route::controller('users', 'UsersController');
Route::controller('password', 'RemindersController');
Route::controller('planets', 'PlanetsController');
Route::controller('comments', 'CommentsController');
Route::controller('tags', 'TagsController');
Route::get('tag/{tag}', 'TagsController@getView');
Route::controller('social-auth', 'SocialAuthController');

// Admin routes
Route::group(array('prefix' => 'admin', 'before' => 'admin'), function() {
    Route::get('/', array('as' => 'admin.index', function() {
        return View::make('admin.layout');
    }));
    Route::gets('news', 'NewsController');
});

// Preview maker
Route::post('preview/make', 'PreviewController@make');
