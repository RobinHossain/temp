<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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

Route::get('/customers/form', function () {
    return view('form');
})->name('customers.form');

Route::post('/customers/form', [CustomerController::class, 'store'])->name('form_submit');

Route::get('/dashboard', [CustomerController::class, 'list'])->middleware(['auth'])->name('dashboard');
Route::get('/customers/getCustomers', [CustomerController::class, 'getCustomers'])->middleware(['auth'])->name('customers.getCustomers');
Route::get('/customers/details/{id}', [CustomerController::class, 'customerDetails'])->middleware(['auth'])->name('customers.details');
Route::post('/customers/createWpAccount', [CustomerController::class, 'createWpAccount'])->middleware(['auth'])->name('customers.createWpAccount');

require __DIR__.'/auth.php';
