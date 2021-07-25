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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', 'Admin\Auth\Processor@load_login');
Route::post('/admin/login', 'Admin\Auth\Processor@login_processor');

Route::group(['namespace'=>'Admin', 'prefix' => 'admin',], function(){
    Route::middleware(['admin_auth'])->group(function () {
        Route::get('/', 'Dashboard@Dashboard');
        Route::get('/logout', 'Auth\Processor@logout');

        // category section
        Route::get('/create-category', 'Category@create_category');
        Route::post('/create-category', 'Category@create_category_now');
        Route::get('/view-categories', 'Category@view_categories');
        Route::get('/delete-category', 'Category@delete_category');
        Route::get('/edit-category', 'Category@edit_category');
        Route::post('/edit-category', 'Category@edit_category_now');

        // article section
        Route::get('/create-article', 'Articles@create_article');
        Route::post('/create-article', 'Articles@create_article_now');
        Route::get('/view-articles', 'Articles@view_articles');
        Route::get('/edit-article', 'Articles@edit_article');
        Route::post('/edit-article', 'Articles@edit_article_now');

    });
});
