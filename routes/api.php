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

    Route::post('/universal-login', 'Api\v1\Auth@universal_login');

    Route::post('/general-auth-otp', 'Api\v1\Auth@general_auth_otp');
});

Route::any('/', function () {
   return "we are watching you ('_')";
});
