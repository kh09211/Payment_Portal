<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// bind invoices to the mail route using 'implicit route model binding'
Route::get('/invoices/{invoice}/mail', 'InvoiceController@mail');

Route::resource('/invoices','InvoiceController');

Route::get('/transactions', 'TransactionController@index');
Route::get('/transactions/{transaction}', 'TransactionController@show');
Route::post('/transactions', 'TransactionController@store');


// routes for processing payments
Route::post('/charge_simple', 'ChargeController@simple'); 

//check to see if invoice exists
Route::post('/existsInvoice', 'InvoiceController@existsInvoice')->name('existsInvoice');

// route invoices numbers on the / to the invoice view using a redirect
// needs to be last
Route::get('/{invoice}',function($invoice) {
	return redirect('/invoices/' . $invoice);
});