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
use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@index')->name('main');

Auth::routes();

Route::get('/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group([
    'prefix' => 'tickets',
    'as' => 'tickets.',
    'namespace' => 'Tickets',
    'middleware' => ['verified:user.home'],
], function () {
    Route::get('/', 'OrderController@index')->name('index');
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
        Route::get('/remove', 'ProfileController@remove')->name('remove');
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
    Route::resource('users', 'UsersController')->except(['edit', 'update']);
    Route::get('/email/{id}', 'EmailController@sendEmail')->name('email');
});

