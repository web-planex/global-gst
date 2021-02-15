<?php

use Illuminate\Support\Facades\Artisan;
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

//--------------------FOR BUSINESS--------------------

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::get('/dashboard', 'Globals\DashboardController@index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes(['verify' => true]);

//Google Login
Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

//SET COMPANY
Route::post('ajax/set_company', 'Globals\UserController@set_company');

//User
Route::get('/edit-profile/{id}', 'Globals\UserController@edit')->name('edit-profile');
Route::patch('/profile_update/{id}', 'Globals\UserController@update')->name('update-profile');
Route::get('change-password', 'Globals\UserController@edit_password')->name('change-password');
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
Route::get('sales/void/{id}', 'Globals\InvoiceController@void');
Route::post('sales/make_payment/{bid}', 'Globals\InvoiceController@make_payment')->name('make_payment');
Route::get('sales/send-mail/{id}', 'Globals\InvoiceController@send_invoice_mail')->name('send-invoice-mail');
Route::post('ajax/get_invoice_product', 'Globals\InvoiceController@get_invoice_product')->name('get_invoice_product');

//Estimate Management
Route::post('/estimate/multiple_pdf', 'Globals\EstimateController@multiple_pdf')->name('estimate-multiple_pdf');
Route::get('download-estimate-pdf-zip', 'Globals\EstimateController@downloadPdfZip')->name('download-estimate-pdf-zip');
Route::post('ajax/estimate_delete_attachment', 'Globals\EstimateController@delete_attachment');
Route::get('ajax/get_address', 'Globals\EstimateController@get_address');
Route::get('/estimate/download_pdf/{id}', 'Globals\EstimateController@download_pdf')->name('estimate-download_pdf');
Route::resource('/estimate', 'Globals\EstimateController');
Route::get('/estimate/delete/{id}', 'Globals\EstimateController@destroy')->name('estimate-delete');
Route::get('/estimate/download_pdf/{id}', 'Globals\EstimateController@download_pdf')->name('estimate-download_pdf');
Route::post('ajax/update_billing_address', 'Globals\EstimateController@update_billing_address');
Route::post('ajax/update_shipping_address', 'Globals\EstimateController@update_shipping_address');
Route::post('ajax/convert_to_invoice', 'Globals\EstimateController@convert_to_invoice');
Route::get('estimate/send-mail/{id}', 'Globals\EstimateController@send_estimate_mail')->name('send-estimate-mail');

// PAYMENT TERMS
Route::resource('/payment-terms', 'Globals\PaymentTermsController');
Route::get('/payment-terms/delete/{id}', 'Globals\PaymentTermsController@destroy');

// PAYMENT METHODS
Route::resource('/payment-methods', 'Globals\PaymentMethodController');
Route::get('/payment-methods/delete/{id}', 'Globals\PaymentMethodController@destroy');

Route::get('/credit-note', 'Globals\InvoiceController@credit_notes')->name('credit-note');
Route::post('/credit-note/multiple_pdf', 'Globals\InvoiceController@multiple_credit_note_pdf')->name('credit-note-multiple_pdf');
Route::get('download-credit-note-pdf-zip', 'Globals\InvoiceController@downloadCreditNotePdfZip')->name('download-credit-note-pdf-zip');
Route::get('credit-note/send-mail/{id}', 'Globals\InvoiceController@send_credit_note_mail')->name('send-credit-note-mail');

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    dd("All Clear");
});

Route::post('generate-multiple-expenses', 'Globals\ExpenseController@multiple_pdf')->name('generate-multiple-expenses');
Route::get('download-pdf-zip', 'Globals\ExpenseController@downloadPdfZip')->name('download-pdf-zip');
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');

// Bill Management
Route::resource('bills', 'Globals\BillController')->except(['destroy']);
Route::get('bills/delete/{id}', 'Globals\BillController@destroy');
Route::get('bills/void/{id}', 'Globals\BillController@void');
Route::post('ajax/payment-terms-store', 'Globals\BillController@payment_terms_store')->name('payment-terms-store');
Route::post('ajax/make_payment/{bid}', 'Globals\BillController@make_payment')->name('make_payment');
Route::post('ajax/bill_delete_attachment', 'Globals\BillController@delete_attachment')->name('bill-delete-attachment');
Route::get('bills/download_pdf/{id}', 'Globals\BillController@download_pdf')->name('download-bill-pdf');
Route::post('generate-multiple-bills', 'Globals\BillController@multiple_pdf')->name('bill-multiple-pdf');
Route::get('download-bill-pdf-zip', 'Globals\BillController@downloadPdfZip')->name('download-bill-pdf-zip');

// Email Templates Management
Route::get('email-templates/{slug}', 'Globals\EmailTemplatesController@show')->name('show-email-template');
Route::patch('email-templates/{slug}', 'Globals\EmailTemplatesController@update')->name('update-email-template');

//Report Builders
Route::get('expense-report', 'Globals\ReportController@expense_report')->name('expense-report');
Route::get('invoice-report', 'Globals\ReportController@invoice_report')->name('invoice-report');
Route::get('estimate-report', 'Globals\ReportController@estimate_report')->name('estimate-report');
Route::get('credit-note-report', 'Globals\ReportController@credit_note_report')->name('credit-note-report');
Route::get('bill-report', 'Globals\ReportController@bill_report')->name('bill-report');


// Debit Notes
Route::resource('debit-notes', 'Globals\DebitNoteController');
Route::get('debit-notes/delete/{id}', 'Globals\DebitNoteController@destroy');
Route::post('ajax/debit_note_delete_attachment', 'Globals\DebitNoteController@delete_attachment')->name('debit-note-delete-attachment');
Route::get('debit-notes/download_pdf/{id}', 'Globals\DebitNoteController@download_pdf')->name('download-debit-note-pdf');
Route::post('generate-multiple-debit-notes', 'Globals\DebitNoteController@multiple_pdf')->name('debit-note-multiple-pdf');
Route::get('download-debit-notes-pdf-zip', 'Globals\DebitNoteController@downloadPdfZip')->name('download-debit-note-pdf-zip');

//--------------------FOR ADMIN SIDE--------------------
Route::group(['prefix' => 'admin','admin/home', 'guard' => 'admin'], function() {
    Route::get('locale/{locale}', function ($locale){
        Session::put('locale', $locale);
        return redirect()->back();
    });
    Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('admin-login');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/','Admin\DashboardController@index');
    Route::get('dashboard','Admin\DashboardController@index');

    //Admin Profile
    Route::get('/edit-profile/{id}', 'Admin\UserController@edit_profile');
    Route::patch('/profile_update/{id}', 'Admin\UserController@update_profile');

    //User Management
    Route::get('/users/delete/{id}', 'Admin\UserController@destroy');
    Route::resource('users', 'Admin\UserController');
});

//--------------------FOR FRONT SIDE--------------------
Route::get('/', 'HomeController@index');
Route::get('/terms-and-conditions', 'HomeController@terms_condition');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::post('/send_contact_mail', 'HomeController@send_contact_mail');

