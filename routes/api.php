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
});

Route::any('/', function () {
   return "we are watching you ('_')";
});
