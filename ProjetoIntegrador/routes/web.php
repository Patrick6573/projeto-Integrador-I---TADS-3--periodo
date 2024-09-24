<?php

use App\Http\Controllers\CadastroCasaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPhoneController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\chatController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:sanctum', 'verified'])->name('dashboard');


Route::middleware('auth:sanctum')->group(function () {
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
    Route::get('/chats', function () {
        return Inertia::render('ChatComponent'); 
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//testes cadastro casa
Route::post('/cadastroCasa',[CadastroCasaController::class,'cadastro'] );


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('web/users', [UserController::class, 'index']);
    Route::get('web/user/me', [UserController::class, 'me']);

    Route::get('web/users/{user}', [UserController::class, 'show']);
    Route::get('web/messages/{user}', [chatController::class, 'listMessages']);
    Route::post('web/messages/store', [chatController::class, 'store']);


});

require __DIR__.'/auth.php';
