<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckTimeAccess;

Route::view('/', 'welcome');

/* Route::resource('/', [Controller::class]); */

Route::get('/age', function () {
    return view('age');
})->name('age.form');

Route::post('/save-age', function (Request $request) {
    $validated = $request->validate([
        'age' => 'required|integer|min:1|max:150'
    ], [
        'age.required' => 'Vui lòng nhập tuổi',
        'age.integer' => 'Tuổi phải là số nguyên',
        'age.min' => 'Tuổi phải lớn hơn 0',
        'age.max' => 'Tuổi phải nhỏ hơn 150'
    ]);

    if ($request->get('age') < 18) return ['message' => 'Access denied.'];

    session(['age' => $validated['age']]);

    return redirect('/');
})->name('age.save');

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

/* Route::prefix('product')->middleware(CheckTimeAccess::class)->group(function () { */
Route::prefix('product')->group(function () {
    Route::controller(ProductController::class)->group(function () {

        /* Route::get('/', 'index')->name('product')->middleware(CheckTimeAccess::class); */
        Route::get('/', 'index')->name('product');

        Route::get('/create', 'create')->name('product.add');

        Route::get('/detail/{id?}', 'detail')->name('product.detail');

        Route::post('/store', 'store')->name('product.store');

        Route::get('/{product}/edit', 'edit')->name('product.store');
        Route::patch('/{product}', 'update')->name('product.store');
        Route::delete('/{product}', 'destroy')->name('product.store');
    });
});

Route::fallback(fn() => view('not-found'));
