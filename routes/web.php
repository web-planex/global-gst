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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/expense', 'Globals\ExpenseController@index')->name('expense');
Route::get('/expense/create', 'Globals\ExpenseController@create')->name('expense-add');

//Payees
Route::get('/payees', 'Globals\PayeeController@index')->name('payees');
Route::get('/payees/create', 'Globals\PayeeController@create')->name('payees-add');
Route::get('/payment-account', 'Globals\PaymentAccountController@index')->name('payment-account');
Route::get('/payment-account/create', 'Globals\PaymentAccountController@create')->name('payment-account-add');
