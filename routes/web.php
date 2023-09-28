<?php

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

Route::middleware(['auth'])->group(function () {
    // Users / Usuários
    Route::name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/usuarios', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::post('/usuarios', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/usuarios/novo', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/usuarios/store', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/usuarios/editar/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('/usuarios/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/usuarios/apagar/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
        Route::get('/usuarios/show_phones/{id}', [\App\Http\Controllers\UserController::class, 'show_phones'])->name('show_phones');
    });
});

Auth::routes();
