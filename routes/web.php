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

Route::get('/form', function () {
    return view('layouts.form');
});

Route::get('/demo/sendmail', [DemoMailController::class, 'sendMail']);

// Route::get('/admin1/{age}', function () {
//     return view('admin');
// })->middleware('CheckAge');

Route::middleware('CheckAge')->group(function () {
    Route::get('/admin1/{age}', function () {
        return view('admin');
    });
});

Route::middleware('auth', 'CheckRole:Subcriber')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// Route::get('/user', [UserController::class, 'index']);
// Route::post('/user/login', [UserController::class, 'login']);

Route::get('/adminbackend', function () {
    return view('layouts.admin');
});
Route::get('/adminbackend/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/formajax', function () {
    return view('news.price');
});

Route::post('/news/update', function () {
    return view('news.update');
});
Route::get('/file', [ProductController::class, 'file']);
Route::post('/upload', [ProductController::class, 'upload'])->name('upload');

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
