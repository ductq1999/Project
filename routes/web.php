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
    return redirect('login');
});
Route::get('login', 'LoginController@getLogin')->name('login');
Route::post('login', 'LoginController@postLogin');
Route::middleware(['auth'])->group(function () {
    Route::get('profile', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('profile', ['user' => $user]);
    })->name('profile');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

Route::get('/table', 'UserController@getAll')->name('table');

Route::post('update', 'UserController@update')->name('update');

Route::get('getEdit/{id}', 'UserController@getEdit')->name('getEdit');

Route::post('postEdit/{id}', 'UserController@postEdit')->name('postEdit');

Route::get('getAdd', 'UserController@getAdd')->name('getAdd');

Route::post('postAdd', 'UserController@postAdd')->name('postAdd');

Route::get('delete/{id}', 'UserController@delete')->name('delete');

Route::get('search', 'UserController@search')->name('search');

Route::get('getCreat', 'UserController@getCreat')->name('getCreat');

Route::post('sendEmail', 'UserController@sendEmail')->name('sendEmail');
