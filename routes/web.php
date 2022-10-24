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
// use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DemoMailController;
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

Route::get('/', function () {
    return view('welcome');
});

//Page Auth
Auth::routes(
    [
        'register' => false,
        'verify' => false,
        'reset' => false,
    ]
);
Route::get('/home', [HomeController::class, 'index'])->name('home');
// ->middleware('verified')
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('user/login', [LoginController::class, 'login']);

// Admin
Route::group(['middleware' => ['auth']], function () {
    // Route Product
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::post('/add', [ProductController::class, 'store'])->name('product.add');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/update', [ProductController::class, 'update'])->name('product.update');
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
        Route::put('/update', [UserController::class, 'update'])->name('user.update');
    });
});
