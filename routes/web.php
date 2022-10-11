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

Route:: get('/news',                [NewsController::class, 'index']);
Route:: get('/news/create',         [NewsController::class, 'create']);
Route:: post('/news/update',         [NewsController::class, 'update']) ->name('news.update');
// Route:: get('/news/update', 'NewsController@update');

Route::get('/khanh/{id?}/page={page}', function ($id, $page) {
    return 'id:'.$id.'-page:'.$page;
});
Route::get('/khanh/profile', function () {
    return route('profile');
}) -> name('profile');
Route::get('/khanh/{text}/{id}', function ($text, $id) {
    return $id.'--'.$text;
}) -> where(['id' => '[0-9]+', 'text' => '[A-Za-z0-9-_]+']);
// Route::get('/test', function () {
//     $product = Test::all();
//     return $product;
// });
Route:: get('/test', [TestController::class, 'index']);
Route:: get('/test/add', [TestController::class, 'add']);
Route:: get('/test/update/{id}', [TestController::class, 'update']);
Route:: get('/test/delete/{id}', [TestController::class, 'delete']);

Route:: get('/posts', [PostController::class, 'index']);
Route:: get('/posts/add', [PostController::class, 'add']);
Route:: get('/posts/read', [PostController::class, 'read']);
Route:: get('/posts/update/{id}', [PostController::class, 'update']);
Route:: get('/posts/delete/{id}', [PostController::class, 'delete']);

Route:: get('/images/read', [FeaturedImagesController::class, 'read']);

Route:: get('/role/show', [RoleController::class, 'show']);


Route::get('/child', function () {
    $users = [
        ['name' => 'Phạm Nguyễn Phương Uyên'],
        ['name' => 'Trần Nguyễn Lan Anh'],
        ['name' => 'Trần Kim Ngân']
    ];

    return view('layouts.child',
    [
        'name' => 'Huỳnh Nhật Khánh',
        'data'=> "<strong>Rivercrane Việt Nam</strong>",
        'id'=> 5,
        'old'=> 22,
        'users' =>  $users
    ]);
});

Route::get('/form', function () {
    return view('layouts.form');
});

Route::get('/news/push', [NewsController::class, 'push']);

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

// Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth', 'CheckRole:Subcriber');
Route::middleware('auth' ,'CheckRole:Subcriber')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// Route::prefix('user')->group(function () {
//     Route::get('/', [UserController::class, 'index']);
//     Route::post('/login', [UserController::class, 'login']);
// });
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
});

Route:: get('/product/{id}', [ProductController::class, 'show']);
