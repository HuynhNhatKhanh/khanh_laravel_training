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
// use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DemoMailController;
use App\Http\Controllers\FeaturedImagesController;


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

Route::get(
    '/', function () {
        return view('welcome');
    }
);

Route::get('/form', function () {
    return view('layouts.form');
});


Route::get('/demo/sendmail', [DemoMailController::class, 'sendMail']);

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');

// Route::get('/admin1/{age}', function () {
//     return view('admin');
// })->middleware('CheckAge');

Route::middleware('CheckAge')->group(function(){
    Route::get('/admin1/{age}', function(){
        return view('admin');
    });
});

Route::middleware('auth' ,'CheckRole:Subcriber')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::get('/user', [UserController::class, 'index']);
Route::post('/user/login', [UserController::class, 'login']);


Route::get('/adminbackend', function(){
    return view('layouts.admin');
});
Route::get('/adminbackend/dashboard', function(){
    return view('admin.dashboard');
});

Route::get('/formajax', function () {
    return view('news.price');
});

Route:: post('/news/update',         function () {
    return view('news.update');
});


Route:: prefix('/product')->group(function () {
    Route:: get('/', [ProductController::class, 'index'])->name('product');
    Route:: get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route:: post('/create', [ProductController::class, 'create'])->name('product.create');
});
//Route:: get('/product/{id}', [ProductController::class, 'show']);
