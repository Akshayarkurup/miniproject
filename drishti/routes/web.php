<?php

use Illuminate\Support\Facades\Route;

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
    return view('visitor/index');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'auth',
    'prefix' => 'user',
],function () {

    Route::get('dashboard', [
        'uses' => 'UserController@getHome',
        'as' => 'dashboard'
    ]);

    Route::get('detect-color/{id}', [
        'uses' => 'UserController@getCanvas',
        'as' => 'colorDetect'
    ]);

    Route::get('color-data', [
        'uses' => 'UserController@setColorData',
        'as' => 'setColorData'
    ]);

    Route::post('submit-image', [
        'uses' => 'UserController@submitImage',
        'as' => 'submitImage'
    ]);

    Route::get('history', [
        'uses' => 'UserController@getHistory',
        'as' => 'history'
    ]);

    Route::get('history/{id}', [
        'uses' => 'UserController@showHistory',
        'as' => 'showHistory'
    ]);

    Route::get('history/delete/{id}', [
        'uses' => 'UserController@deleteHistory',
        'as' => 'deleteHistory'
    ]);

    Route::get('profile', [
        'uses' => 'UserController@getProfile',
        'as' => 'profile'
    ]);

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
