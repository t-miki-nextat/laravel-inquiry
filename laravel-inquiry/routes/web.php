<?php
declare(strict_types=1);

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

Route::get('/inquiries', function () {
    return view('inquiries');
});

Route::post('/inquiries', function () {
    return view('welcome');
});

Route::get('/inquiries/complete', function () {
    return view('welcome');
});
