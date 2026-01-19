<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('/', function () {
        return view('product.index');
    })->name('product');

    Route::get('/create', function () {
        return view('product.add');
    })->name('product.add');

    Route::get('/{id?}', function (?string $id = '1') {
        return view('product.detail', ['id' => $id]);
    })->name('product.detail');
});

Route::fallback(fn() => view('not-found'));
