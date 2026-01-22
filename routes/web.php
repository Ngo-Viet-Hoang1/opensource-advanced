<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/create', [AuthController::class, 'create']);

Route::get('/student/{name?}/{id?}', function (string $name = 'HieuLuongXuan', string $id = '123456') {
    return view('student-info', ['name' => $name, 'id' => $id]);
});

Route::get('/chess-board/{n?}', function (int $n = 8) {
    return view('chess-board', ['n' => $n]);
});

Route::get('/about', function () {
    return view('about');
});

Route::prefix('product')->group(function () {
    Route::controller(ProductController::class)->group(function () {

        Route::get('/', 'index')->name('product');

        Route::get('/create', 'create')->name('product.add');

        Route::get('/detail/{id?}', 'detail')->name('product.detail');

        Route::post('/store', 'store')->name('product.store');
    });
});

Route::fallback(fn() => view('not-found'));
