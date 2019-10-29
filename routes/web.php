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

use App\Http\Middleware\FilledProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

//DB::listen(function($query) {
//    var_dump($query->sql, $query->bindings);
//});

Route::get('/', 'MainController@index')->name('main');

Auth::routes();

Route::get('/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/forgot', 'Auth\ForgotPasswordController@index')->name('password.forgot');
Route::post('/forgot', 'Auth\ForgotPasswordController@sendEmail')->name('forgot.email');
Route::get('/reset/{id}/{token}', 'Auth\ResetPasswordController@resetForm')->name('reset.form');
Route::put('/reset/{id}', 'Auth\ResetPasswordController@reset')->name('password.reset');

Route::group([
    'prefix' => 'tickets',
    'as' => 'tickets.',
    'namespace' => 'Tickets',
    'middleware' => ['verified:user.home'],
], function () {
    Route::get('/', 'OrderController@index')->name('index');
    Route::get('/order/{ticket}', 'OrderController@orderForm')
        ->name('order.form')
        ->middleware(FilledProfile::class);
    Route::post('/order/{ticket}', 'OrderController@order')
        ->name('order')
        ->middleware(FilledProfile::class);
    Route::get('/failed', 'OrderController@failed')->name('failed');
    Route::delete('/remove/{ticket}', 'OrderController@remove')->name('remove');
});

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'namespace' => 'User',
    'middleware' => ['auth',],
], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], function () {
        Route::get('/', 'ProfileController@index')->name('index');
        Route::get('/edit', 'ProfileController@edit')->name('edit');
        Route::put('/update', 'ProfileController@update')->name('update');
        Route::delete('/delete', 'ProfileController@destroy')->name('destroy');
    });
});

Route::group([
    'prefix' => 'ajax',
    'as' => 'ajax.',
    'namespace' => 'Ajax',
    'middleware' => ['ajax'],
], function () {
    Route::get('/city/{name}', 'CityController@find')->name('city');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['can:admin-panel',]
], function () {
    Route::get('/', 'MainController@index')->name('main');
    Route::resource('tickets', 'TicketsController');
    Route::get('tickets/remove/{ticket}', 'TicketsController@remove')->name('tickets.remove');
    Route::resource('users', 'UsersController')->except(['edit', 'update', 'show']);
    Route::get('/email/{ticket}/{id?}', 'EmailController@newEmail')->name('email.new');
    Route::post('/email/{ticket}/{id?}', 'EmailController@sendEmail')->name('email.send');
});

