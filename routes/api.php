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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// api router for version 1
Route::prefix('v1')->middleware(['api_auth_v1'])->group(function () {
    Route::post('/', function(){
        return 'reached hommies';
    });

    // user_auth
    Route::post('/auth_user_in', 'Api\v1\Auth@auth_user_in');
    Route::post('/get_all_categories', 'Api\v1\Auth@get_all_categories');
    Route::post('/finalize_regis', 'Api\v1\Auth@finalize_regis');

    // app get data
    Route::post('/user-information/{id}', 'Api\v1\Auth@user_information');

    // push noti reg
    Route::post('/reg-push-token', 'Api\v1\Auth@reg_push_token');

    // load user home
    Route::post('/get-home-info', 'Api\v1\Loader@get_home_info');
    Route::post('/get-home-info-single', 'Api\v1\Loader@get_home_info_single');
});

Route::any('/', function () {
   return "we are watching you ('_')";
});
