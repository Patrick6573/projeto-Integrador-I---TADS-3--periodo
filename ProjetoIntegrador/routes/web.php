<?php

use App\Http\Controllers\VisitaController;
use App\Http\Controllers\CadastroCasaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Property_photosController;
use App\Http\Controllers\UserPhoneController;
use Illuminate\Support\Facades\Auth;
use App\Models\CadastroCasa;
use App\Models\Property_photos;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\chatController;
use Illuminate\Http\Request;

Route::get('/', function () {

        $propertys = CadastroCasa::with('files')->get();
    
        foreach ($propertys as $property) {
            // Se a relação existir, pega apenas o nome do arquivo da foto primária
            $property->primary_photo = $property->files->firstWhere('type_file', 'FOTO PRIMÁRIA')?->name_file;
        }
    
        return view('dashboard', ['propertys' => $propertys]);
    });

Route::get('/dashboard', function(){

        $propertys = CadastroCasa::with('files')->get();

        foreach ($propertys as $property) {
            // Se a relação existir, pega apenas o nome do arquivo da foto primária
            $property->primary_photo = $property->files->firstWhere('type_file', 'FOTO PRIMÁRIA')?->name_file;
        }

        return view('dashboard', ['propertys' => $propertys]);
    
    
})->middleware(['auth:sanctum', 'verified'])->name('dashboard');




Route::post('/enviarVisit/{idCasa}', [VisitaController::class, 'solicitarVisit'])->name('enviarVisit');

Route::get('/visitas/{id}/editar', [VisitaController::class, 'update'])->name('visitas.editar');
// Route::post('/enviarVisitaEdit/{id}/atualizar', [VisitaController::class, 'update'])->name('visitas.update');
Route::put('/visitas/{id}/atualizar', [VisitaController::class, 'update'])->name('visitas.update');
Route::put('/visitas/{id}/cancelar', [VisitaController::class, 'cancelar'])->name('visitas.cancelar');
Route::put('/visitas/{id}/recusar', [VisitaController::class, 'recusar'])->name('visitas.recusar');
Route::delete('/visitas/{id}/excluir', [VisitaController::class, 'excluir'])->name('visitas.excluir');


Route::get('/minhasvisitas', [VisitaController::class, 'minhasVisitas'])->name('minhas.visitas');


Route::put('/visitas/{id}/confirmar', [VisitaController::class, 'confirmarVisita'])->name('visitas.confirmar');

Route::get('/exibirForm/{id}', [VisitaController::class, 'showFormVisit'])->name('exibir.form');





Route::middleware('auth:sanctum')->group(function () {





    Route::get('/cadastroCasa', function () {
        return view('casas/cadastroCasa');
    });
    Route::get('/imovel', function () {
        return view('casas/imovel');
    });
    Route::get('/minhasCasas', function () {
        $userID = Auth::id();
        $propertys = CadastroCasa::with('files')->where('fk_id_user', $userID)->get();
        foreach ($propertys as $property) {

            $property->primary_photo= $property->files->firstWhere('type_file', 'FOTO PRIMÁRIA')?->name_file;
        }
            return view('casas.minhasCasas',['properties' => $propertys]);

    })->middleware(['auth:sanctum']);

    Route::get('/casa/{id}', function($id) {
        $property = CadastroCasa::with('files')->findOrFail($id);
        $property->primary_photo = $property->files->firstWhere('type_file', 'FOTO PRIMÁRIA');
        $property->photos = $property->files
        ->whereIn('type_file', ['photo', 'video']) // Filtra apenas fotos e vídeos
        ->pluck('name_file') // Pega apenas os nomes dos arquivos
        ->toArray(); // Converte para array
        return view('casas.casa', compact('property'));
    })->middleware(['auth:sanctum', 'verified'])->name('casa');

    Route::get('/property/edit/{id}', [CadastroCasaController::class, 'edit'])->name('property.edit');

    Route::put('/casas/{id}', function(Request $request, $id) {
        $property = CadastroCasa::findOrFail($id);

        // Validação e atualização do modelo...

        $property->update($request->all());

        // Redirecionar após a atualização
        return redirect()->route('casas.minhasCasas')->with('success', 'Casa atualizada com sucesso!');

    })->middleware(['auth:sanctum', 'verified'])->name('casas.update');
    Route::delete('/property/delete/{id}', [CadastroCasaController::class, 'destroy'])->name('property.delete');


    Route::get('/minhasVisitas', [VisitaController::class, 'minhasVisitas'])->name('minhasVisitas');

    Route::get('/chats', function () {
        return Inertia::render('ChatComponent');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/cadastroCasa',[CadastroCasaController::class,'cadastro'] );
Route::delete('/minhasCasas/{id}',[CadastroCasaController::class , 'destroy']);
//

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
