<?php
/**
 * Web Routes
 *
 * PHP version 8
 *
 * @category  Routes
 * @package   Routes
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;

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

//Use Route of Auth
Auth::routes();

// Admin middleware auth
Route::group(['middleware' => ['auth']], function () {
    //Route Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logoutUser');
    // Route Product
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::post('/getdata', [ProductController::class, 'getProduct'])->name('product.getdata');
        Route::post('/delete', [ProductController::class, 'delete'])->name('product.delete');
        Route::post('/add', [ProductController::class, 'store'])->name('product.add');
        Route::post('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    });
    // Route User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::post('/delete', [UserController::class, 'delete'])->name('user.delete');
        Route::post('/status', [UserController::class, 'status'])->name('user.status');
        Route::post('/search', [UserController::class, 'search'])->name('user.search');
        Route::post('/getdata', [UserController::class, 'getUser'])->name('user.getdata');
        Route::post('/add', [UserController::class, 'store'])->name('user.add');
        Route::put('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    });
    // Route Customer
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer');
        Route::post('/getdata', [CustomerController::class, 'getCustomer'])->name('customer.getdata');
        Route::post('/add', [CustomerController::class, 'store'])->name('customer.add');
        Route::put('/edit', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/import', [CustomerController::class, 'import'])->name('customer.import');
        Route::get('/export', [CustomerController::class, 'export'])->name('customer.export');
    });
});
