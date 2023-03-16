<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'inquiries', 'as' => 'inquiries.'], function () {
    Route::get('/', [InquiryController::class, 'form'])->name('form');

    Route::get('complete', [InquiryController::class, 'complete'])->name('complete');

    Route::post('store', [InquiryController::class, 'store'])->name('store');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'showDashboard'])->name('top');
    Route::group(['prefix' => 'inquiries', 'as' => 'inquiries.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('inquiries');
        Route::get('{id}', [AdminController::class, 'show'])->name('show');
    });
    Route::resource('admin', AdminController::class);
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('{id}', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('{id}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('{id}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::get('create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
    });
});
