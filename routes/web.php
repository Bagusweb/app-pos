<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;


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
    return redirect(route('login'));
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//membuat route login dan register
Route::get('/login', [AuthenController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthenController::class, 'proseslogin'])->name('login.post');
Route::get('/register', [AuthenController::class, 'showregister'])->name('register');
Route::post('/register', [AuthenController::class, 'prosesregister'])->name('register.post');
Route::get('/logout', [AuthenController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:Admin'])->group(function(){

    //membuat admin dashboard
    Route::get('/admindashboard', [DashboardController::class, 'admindashboard'])->name('admin.index');


    //membuat route Categories
Route::get('/category', [CategoriesController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoriesController::class, 'create'])->name('category.create');
Route::post('/category', [CategoriesController::class, 'store'])->name('category.store');
Route::get('/category/{id}/edit', [CategoriesController::class, 'edit'])->name('category.edit');
Route::put('/category/{id}', [CategoriesController::class, 'update'])->name('category.update');
Route::delete('/category/{id}', [CategoriesController::class, 'destroy'])->name('category.destroy');

//membuat route user
Route::get('/user', [UsersController::class, 'index'])->name('user.index');
Route::get('/user/create', [UsersController::class, 'create'])->name('user.create');
Route::post('/user', [UsersController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
Route::put('user/{id}', [UsersController::class, 'update'])->name('user.update');
Route::delete('user/{id}', [UsersController::class, 'destroy'])->name('user.destroy');

//membuat product route
Route::get('/product', [ProductsController::class, 'index'])->name('product.index'); //untuk menampilkan index
Route::get('/product/create', [ProductsController::class, 'create'])->name('product.create'); //untuk menampilkan form product
Route::post('/product', [ProductsController::class, 'store'])->name('product.store'); // untuk melakukan proses simpan
Route::get('/product/{id}/edit', [ProductsController::class, 'edit'])->name('product.edit'); //untuk menampilkan form edit sesuai id
Route::put('product/{id}', [ProductsController::class, 'update'])->name('product.update'); //untuk melakukan proses update sesuai id
Route::delete('product/{id}', [ProductsController::class, 'destroy'])->name('product.destroy'); //untuk menghapusan proses delete sesuai id

//membuat route customers
Route::get('/customer', [CustomersController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomersController::class, 'create'])->name('customer.create');
Route::post('/customer', [CustomersController::class, 'store'])->name('customer.store');
Route::get('/customer/{id}/edit', [CustomersController::class, 'edit'])->name('customer.edit');
Route::put('customer/{id}', [CustomersController::class, 'update'])->name('customer.update');
Route::delete('customer/{id}', [CustomersController::class, 'destroy'])->name('customer.destroy');

//Membuat Laporan
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::post('/report/generate', [ReportController::class, 'generatePDF'])->name('report.generate');
Route::get('/report/filter', [ReportController::class, 'filter'])->name('report.filter');
});

Route::middleware(['auth', 'role:Cashier'])->group(function () {

    //membuat route dasboard cashier
     Route::get('/cashierdashboard', [DashboardController::class, 'cashierdashboard'])->name('cashier.index');

    //membuat route transactions
    Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('transaction', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::delete('transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

    //route untuk print sesuai id di halaman transactions
    Route::get('/report/transaction/{id}', [ReportController::class, 'generatePDFByTransactionId'])->name('report.generateid');
});
