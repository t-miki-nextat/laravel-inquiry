<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Inquiry\FormController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', [FormController::class, 'form'])->name('form');

    Route::get('complete', [FormController::class, 'complete'])->name('complete');

    Route::post('store', [FormController::class, 'store'])->name('store');
});

Route::group( ['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [InquiryController::class, 'showDashboard'])->name('top');
    Route::group(['prefix' => 'inquiries', 'as' => 'inquiries.'], function () {
        Route::get('/', [InquiryController::class, 'index'])->name('inquiries');
        Route::get('{id}', [InquiryController::class, 'show'])->name('show');
    });
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('create', [UserController::class, 'store'])->name('store');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::get('{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('{id}', [UserController::class, 'update'])->name('update');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});
