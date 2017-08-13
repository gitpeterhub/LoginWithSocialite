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
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

//for any social media login with socialite
Route::get ( '/redirect/{service}', 'Auth\LoginController@redirectToProvider' );
Route::get ( '/callback/{service}', 'Auth\LoginController@handleProviderCallback' );

//for login and registration routes
//Auth::routes();
// Authentication Routes...

//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
//uses laravel's default login routes
Route::post('login', 'Auth\LoginController@login');
//Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');

Route::group(['prefix' => '/admin',  'middleware' => 'auth'], function()
{
	//Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);
   $this->get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

   //uses laravel's default logout routes
   
   $this->get('/logout', 'Auth\LoginController@logout')->name('logout');
   
});
// Registration Routes...

//$this->get('console/register', 'Auth\RegisterController@showRegisterForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');


