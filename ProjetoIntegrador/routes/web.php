<?php

use App\Http\Controllers\CadastroCasaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/cadastroCasa', function () {
    return view('casas/cadastroCasa');
});
Route::get('/imovel', function () {
    return view('casas/imovel');
});
Route::get('/minhasCasas', function () {
    return view('casas/minhasCasas');
});
Route::get('/casa', function () {
    return view('casas/casa');
});
Route::get('/minhasVisitas', function () {
    return view('casas/minhasVisitas');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/cadastroCasa', function () {
        return view('casas/cadastroCasa');
    });
    Route::get('/imovel', function () {
        return view('casas/imovel');
    });
    Route::get('/minhasCasas', function () {
        return view('casas/minhasCasas');
    });
    Route::get('/casa', function () {
        return view('casas/casa');
    });
    Route::get('/minhasVisitas', function () {
        return view('casas/minhasVisitas');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//testes cadastro casa
Route::post('/cadastroCasa',[CadastroCasaController::class,'cadastro'] );

require __DIR__.'/auth.php';
