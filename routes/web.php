<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;

use App\Models\User;
use Illuminate\Support\Facades\DB;

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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    echo "not allowed";
});


Route::get('/about', function(){
    return view('about');
});

Route::get('/contact', function(){
    echo "Hello there contact";
});


Route::get('/test', function(){
    return view('test');
});

//category controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'Update']);

Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftDelete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']);
Route::get('/pdelete/category/{id}', [CategoryController::class, 'Pdelete']);

//Brand cotroller
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'Update']);
Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);

//Multi Image 
Route::get('/multi/image', [BrandController::class, 'Multpic'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StoreImg'])->name('store.image');



Route::get('/contact', [ContactController::class, 'index'])->name('con');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    // $users = User::all();
    // $users = DB::table('users')->get();

    // return view('dashboard', compact('users'));
    return view('admin.index');

})->name('dashboard');


//User
Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');