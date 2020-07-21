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
    return view('test'); // THIS NEEDS TO BE FIXED
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/invoices','InvoiceController');
Route::get('/transactions', 'TransactionController@index');
Route::get('/transactions/{transaction}', 'TransactionController@show');
Route::post('/transactions', 'TransactionController@store');

// route invoices numbers on the / to the invoice view using 'implicit route model binding'
/*
Route::get('/{invoice}',function(\App\Invoice $invoice) {
	dd({})
	return view('invoices.show', compact('invoice'));
});
*/
Route::get('/{invoice}',function($invoice) {
	return redirect('/invoices/' . $invoice);
});
