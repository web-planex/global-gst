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
    return view('auth.login');
});

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

//Forgot Password







Route::get('/reset-password', 'Globals\UserController@reset_password')->name('reset-password');
Route::post('/reset_password', 'Globals\UserController@change_password')->name('reset_password');

Route::post('/forgot_password', 'Globals\UserController@forgot_password')->name('forgot-password');

//User
Route::get('/edit-profile/{id}', 'Globals\UserController@edit')->name('edit-profile');
Route::patch('/profile_update/{id}', 'Globals\UserController@update')->name('update-profile');
Route::get('/change-password/{id}', 'Globals\UserController@edit_password')->name('change-password');
Route::patch('/update_password/{id}', 'Globals\UserController@update_password')->name('update-password');

Route::get('/expense', 'Globals\ExpenseController@index')->name('expense');
Route::get('/expense/create', 'Globals\ExpenseController@create')->name('expense-add');

//Payees
Route::get('/payees', 'Globals\PayeeController@index')->name('payees');
Route::get('/payees/create', 'Globals\PayeeController@create')->name('payees-add');
Route::post('/payees', 'Globals\PayeeController@store')->name('payees-store');
Route::get('/payees/delete/{id}', 'Globals\PayeeController@delete')->name('payees-delete');

//Payment
Route::get('/payment-account', 'Globals\PaymentAccountController@index')->name('payment-account');
Route::get('/payment-account/create', 'Globals\PaymentAccountController@create')->name('payment-account-add');
Route::any('/payment-account/addedit', 'Globals\PaymentAccountController@addedit')->name('payment-account-insert');
Route::any('/payment-account/delete/{id}', 'Globals\PaymentAccountController@delete')->name('payment-account-delete');
Route::post('/ajax/get-account-type', 'Globals\PaymentAccountController@ajaxGetAccountType')->name('ajax-get-account-type');
