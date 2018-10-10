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
    Route::get('/callback_social/{driver}', 'SocialLoginController@show');
    Route::post('/callback_social/facebook', 'SocialLoginController@facebook');
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'LoginController@getAuthenticatedUser');
    Route::get('categories_features', 'CategoryFeatureController@index');
    Route::post('/category/{category_id}/feature/{feature_id}', 'BetController@store');
});