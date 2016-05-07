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

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'WelcomeController@index');

    // Authenticated Users Only
    Route::group(['middleware' => 'auth'], function () {
        Route::resource('/collections', 'CollectionController', ['except' => ['index', 'show', 'edit']]);
        Route::resource('/miniatures', 'MiniatureController', ['only' => ['update', 'store', 'destroy', 'photos']]);
        Route::post(
            '/miniatures/{slug}/photos',
            ['uses' => 'MiniatureController@uploadPhotos', 'as' => 'miniatures.photos']
        );
        Route::resource('/photos', 'PhotoController', ['only' => ['destroy', 'update']]);
        Route::resource('/users', 'UserController', ['only' => 'update']);
    });
    
    Route::resource('/collections', 'CollectionController', ['only' => ['index', 'show']]);
    Route::resource('/miniatures', 'MiniatureController', ['only' => ['show']]);
    Route::resource('/photos', 'PhotoController', ['only' => 'show']);
    Route::get('/sitemap', ['as' => 'sitemap.index', 'uses' => 'SitemapController@index']);

    Route::get('/privacy-policy', ['as' => 'privacy-policy', 'uses' => function() {
        return view('pages.privacy_policy');
    }]);

    Route::get('/terms-of-service', ['as' => 'terms-of-service', 'uses' => function() {
        return view('pages.terms_of_service');
    }]);
});
