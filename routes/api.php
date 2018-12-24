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


Route::post('register', 'LoginController@register');
Route::post('login', 'LoginController@authenticate');
Route::get('categories', 'CategoryController@index');

Route::group(['middleware' => ['web']], function () {
    Route::get('/login_social/{driver}', 'SocialLoginController@show');
    Route::get('/callback_social/facebook', 'SocialLoginController@facebook');
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'LoginController@getAuthenticatedUser');
    Route::get('user/{user_id}/bets', 'BetController@show');
    Route::get('user/{user_id}/watches', 'WatchController@show');

    Route::get('categories_features', 'CategoryFeatureController@index');
    Route::get('me/bets', 'BetController@show');
    Route::get('me/watches', 'WatchController@show');
    
    Route::post('/watches/{feature_id}', 'WatchController@store');
    Route::post('/category/{category_id}/feature/{feature_id}', 'BetController@store');
});