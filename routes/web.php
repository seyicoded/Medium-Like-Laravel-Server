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
    });
});
