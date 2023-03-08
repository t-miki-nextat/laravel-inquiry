<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController;

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

Route::group(['prefix'=>'inquiries'], function(){

Route::get('/', [InquiryController::class, 'form'])->name('form');

Route::get('complete', [InquiryController::class, 'complete'])->name('complete');

});

Route::post('store', [InquiryController::class, 'store'])->name('inquiries.store');


