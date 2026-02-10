<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::get('sign-in', [AuthController::class, 'SignIn']);
Route::post('sign-in', [AuthController::class, 'CheckSignIn']);

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

        Route::get('/{product}/edit', 'edit')->name('product.edit');
        Route::patch('/{product}', 'update')->name('product.update');
        Route::delete('/{product}', 'destroy')->name('product.destroy');
    });
});

Route::prefix('categories')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('categories.index');

        Route::get('/create', 'create')->name('categories.create');

        Route::post('/store', 'store')->name('categories.store');

        Route::get('/{category}', 'show')->name('categories.show');

        Route::get('/{category}/edit', 'edit')->name('categories.edit');

        Route::patch('/{category}', 'update')->name('categories.update');

        Route::delete('/{category}', 'destroy')->name('categories.destroy');
    });
});

Route::view('/admin', 'layout.admin-layout');

Route::get('/login', [AuthController::class, 'index'])->name('login.form');
Route::get('/register', [AuthController::class, 'register'])->name('register.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'create'])->name('register.process');

Route::fallback(fn() => view('not-found'));
