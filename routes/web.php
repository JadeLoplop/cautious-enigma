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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('users')->as('users.')->group(function(){
        Route::get('/', ['\App\Http\Controllers\UserController', 'index'])->name('index'); //listing
        Route::get('create', ['\App\Http\Controllers\UserController', 'create'])->name('create'); //create
        Route::post('create', ['\App\Http\Controllers\UserController', 'store'])->name('store'); //store
        Route::get('{user}/show', ['\App\Http\Controllers\UserController', 'show'])->name('show'); //show details
        Route::get('{user}/edit', ['\App\Http\Controllers\UserController', 'edit'])->name('edit'); //edit page
        Route::patch('{user}/update', ['\App\Http\Controllers\UserController', 'update'])->name('update'); //update
        Route::delete('{user}/destroy', ['\App\Http\Controllers\UserController', 'destroy'])->name('destroy'); //destroy a user/ removing from the database
        Route::softDeletes();
        // Route::get('trashed', ['\App\Http\Controllers\UserController', 'trashed'])->name('trashed'); //trashed page for users who got soft deleted
        // Route::get('restore', ['\App\Http\Controllers\UserController', 'restore'])->name('restore'); // restore user who got soft deleted
        // Route::get('delete', ['\App\Http\Controllers\UserController', 'delete'])->name('delete'); //permanently remove user who got soft deleted/ removing from the database
    });
});
