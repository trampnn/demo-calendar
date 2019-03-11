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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'API\RegisterController@register');
  
Route::middleware('auth:api')->group( function () {
	Route::resource('users', 'API\UserController');

	Route::post('nks/user', 'API\UserController@show');
	Route::post('nks/users/updateInfo', 'API\UserController@updateInfo');
	Route::post('nks/users/updateAvatar', 'API\UserController@updateAvatar');
});



Route::post('nks/posts', 'API\PostController@index');
Route::post('nks/post', 'API\PostController@show');
Route::post('nks/posts/add', 'API\PostController@store');
Route::post('nks/posts/update', 'API\PostController@update');
Route::post('nks/posts/delete', 'API\PostController@destroy');
Route::post('nks/posts/updateImg', 'API\PostController@updateImg');

Route::post('nks/categories', 'API\CategoryController@index');
Route::post('nks/categories-dropdown', 'API\CategoryController@showDropdown');

Route::post('nks/galleries', 'API\GalleryController@index');
Route::post('nks/galleries/delete', 'API\GalleryController@destroy');

Route::post('nks/site-settings', 'API\SettingController@site');
Route::post('nks/admin-settings', 'API\SettingController@admin');
Route::post('nks/setting', 'API\SettingController@show');
Route::post('nks/settings/update', 'API\SettingController@update');

// === Systen Route === //

Route::resource('continents', 'API\ContinentController');
Route::resource('countries', 'API\CountryController');
Route::resource('provinces', 'API\ProvinceController');
Route::resource('districts', 'API\ProvinceController');
Route::resource('wards', 'API\ProvinceController');

// === Core Route === //

// Continent
Route::post('nks/continents', 'API\ContinentController@index');
Route::post('nks/continent', 'API\ContinentController@show');
Route::post('nks/continents-dropdown', 'API\ContinentController@showDropdown');

// Country
Route::post('nks/countries', 'API\CountryController@index');
Route::post('nks/country', 'API\CountryController@show');
Route::post('nks/countries-dropdown', 'API\CountryController@showDropdown');
Route::post('nks/countries-world', 'API\CountryController@showWorld');
Route::post('nks/country/polygon', 'API\CountryController@polygon');

// Province
Route::post('nks/provinces/', 'API\ProvinceController@index');
Route::post('nks/province/', 'API\ProvinceController@show');
Route::post('nks/provinces-dropdown/', 'API\ProvinceController@showDropdown');
Route::post('nks/countries-world', 'API\CountryController@showWorld');
Route::post('nks/province/polygon/', 'API\ProvinceController@polygon');

// District
Route::post('nks/districts/', 'API\DistrictController@index');
Route::post('nks/district/', 'API\DistrictController@show');
Route::post('nks/districts-dropdown/', 'API\DistrictController@showDropdown');
Route::post('nks/district/polygon/', 'API\DistrictController@polygon');

// Ward
Route::post('nks/wards/', 'API\WardController@index');
Route::post('nks/ward/', 'API\WardController@show');
Route::post('nks/wards-dropdown/', 'API\WardController@showDropdown');
Route::post('nks/ward/polygon/', 'API\WardController@polygon');







// === Site Route === //