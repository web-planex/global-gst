<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Globals\BillController;
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

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Auth::routes(['verify' => true]);

//Google Login
Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

//SET COMPANY
Route::post('ajax/set_company', 'Globals\UserController@set_company');

//User
Route::get('/edit-profile/{id}', 'Globals\UserController@edit')->name('edit-profile');
Route::patch('/profile_update/{id}', 'Globals\UserController@update')->name('update-profile');
Route::get('/change-password/{id}', 'Globals\UserController@edit_password')->name('change-password');
Route::patch('/update_password/{id}', 'Globals\UserController@update_password')->name('update-password');

//Expense
Route::post('ajax/expense_delete_attachment', 'Globals\ExpenseController@delete_attachment');
Route::post('ajax/get_product', 'Globals\ExpenseController@get_product')->name('get_product');
Route::post('ajax/product-store', 'Globals\ExpenseController@product_store')->name('product-store');
Route::post('ajax/expense-type-store', 'Globals\ExpenseController@expense_type_store')->name('expense-type-store');
Route::post('ajax/get-expense-type', 'Globals\ExpenseController@get_expense_type')->name('get-expense-type');
Route::post('ajax/payees-store', 'Globals\ExpenseController@payee_store')->name('payee-store');
Route::post('ajax/payment-account-store', 'Globals\ExpenseController@payment_account_store')->name('payment-account-store');
Route::get('/expense', 'Globals\ExpenseController@index')->name('expense');
Route::get('/expense/create', 'Globals\ExpenseController@create')->name('expense-add');
Route::post('/expense/insert', 'Globals\ExpenseController@insert')->name('expense-insert');
Route::get('/expense/edit/{id}', 'Globals\ExpenseController@edit')->name('expense-edit');
Route::patch('/expense/update/{id}', 'Globals\ExpenseController@update')->name('expense-update');
Route::get('/expense/delete/{id}', 'Globals\ExpenseController@delete')->name('expense-delete');
Route::get('/expense/download_pdf/{id}', 'Globals\ExpenseController@download_pdf')->name('expense-download_pdf');
//Route::get('/expense/print-pdf/{id}', 'Globals\ExpenseController@print_pdf')->name('expense-print-pdf');

//Payees
Route::get('/payees', 'Globals\PayeeController@index')->name('payees');
Route::get('/payees/create', 'Globals\PayeeController@create')->name('payees-add');
Route::post('/payees', 'Globals\PayeeController@store')->name('payees-store');
Route::get('/payees/edit/{id}', 'Globals\PayeeController@edit')->name('payees-edit');
Route::patch('/payees/update/{id}', 'Globals\PayeeController@update')->name('payees-update');
Route::get('/payees/delete/{id}', 'Globals\PayeeController@delete')->name('payees-delete');

//Payment
Route::get('/payment-account', 'Globals\PaymentAccountController@index')->name('payment-account');
Route::get('/payment-account/create', 'Globals\PaymentAccountController@create')->name('payment-account-add');
Route::get('/payment-account/edit/{id}', 'Globals\PaymentAccountController@edit')->name('payment-account-edit');
Route::any('/payment-account/addedit', 'Globals\PaymentAccountController@addedit')->name('payment-account-insert');
Route::any('/payment-account/addedit/{id}', 'Globals\PaymentAccountController@addedit')->name('payment-account-update');
Route::any('/payment-account/delete/{id}', 'Globals\PaymentAccountController@delete')->name('payment-account-delete');
Route::post('/ajax/get-account-type', 'Globals\PaymentAccountController@ajaxGetAccountType')->name('ajax-get-account-type');

//Invoice Setting
Route::get('/company-setting', 'Globals\InvoiceSettingController@index');
Route::any('/company-setting/addedit', 'Globals\InvoiceSettingController@store')->name('company-setting-add');

//Company Management
Route::resource('/companies', 'Globals\CompanyController');
Route::get('/companies/delete/{id}', 'Globals\CompanyController@destroy');

//Product Management
Route::post('/products/import', 'Globals\ProductController@import_product');
Route::get('/products/export_product', 'Globals\ProductController@export_product');
Route::resource('/products', 'Globals\ProductController');
Route::get('/products/delete/{id}', 'Globals\ProductController@destroy');

//Invoice Management
Route::post('/sales/multiple_pdf', 'Globals\InvoiceController@multiple_pdf')->name('invoice-multiple_pdf');
Route::get('download-invoice-pdf-zip', 'Globals\InvoiceController@downloadPdfZip')->name('download-invoice-pdf-zip');
Route::post('ajax/delete_attachment', 'Globals\InvoiceController@delete_attachment');
Route::post('ajax/getEmail', 'Globals\InvoiceController@getEmail');
Route::get('/sales/download_pdf/{id}', 'Globals\InvoiceController@download_pdf')->name('sales-download_pdf');
Route::resource('/sales', 'Globals\InvoiceController');
Route::get('/sales/delete/{id}', 'Globals\InvoiceController@destroy')->name('sales-delete');
Route::get('/sales/download_pdf/{id}', 'Globals\InvoiceController@download_pdf')->name('invoice-download_pdf');

// PAYMENT TERMS
Route::resource('/payment-terms', 'Globals\PaymentTermsController');
Route::get('/payment-terms/delete/{id}', 'Globals\PaymentTermsController@destroy');

// PAYMENT METHODS
Route::resource('/payment-methods', 'Globals\PaymentMethodController');
Route::get('/payment-methods/delete/{id}', 'Globals\PaymentMethodController@destroy');

Route::get('/credit-note', 'Globals\InvoiceController@credit_notes')->name('credit-note');
Route::post('/credit-note/multiple_pdf', 'Globals\InvoiceController@multiple_credit_note_pdf')->name('credit-note-multiple_pdf');
Route::get('download-credit-note-pdf-zip', 'Globals\InvoiceController@downloadCreditNotePdfZip')->name('download-credit-note-pdf-zip');

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    dd("All Clear");
});

Route::post('generate-multiple-expenses', 'Globals\ExpenseController@multiple_pdf')->name('generate-multiple-expenses');
Route::get('download-pdf-zip', 'Globals\ExpenseController@downloadPdfZip')->name('download-pdf-zip');
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::resources([
    'bills' => BillController::class
]);