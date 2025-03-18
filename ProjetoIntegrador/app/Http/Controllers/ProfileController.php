<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function edit(Request $request): View
{
    $user = $request->user()->load('phones'); // Carrega o usuário com seus telefones
    return view('profile.edit', [
        'user' => $user,
    ]);
}



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Atualiza os dados do usuário
        $request->user()->fill($request->validated());

        // Verifica se o e-mail foi alterado e marca como não verificado
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('user_photo') && $request->file('user_photo')->isValid()) {
        
            // Se o usuário já tiver uma foto de perfil, exclua a antiga
            if ($request->user()->user_photo && file_exists(public_path("profile_photos/{$request->user()->user_photo}"))) {
                unlink(public_path("profile_photos/{$request->user()->user_photo}"));
            }
        
            // Capturando a extensão do arquivo enviado
            $extension = $request->user_photo->extension();
            
            // Gerando um novo nome de arquivo único
            $imageName = md5($request->user_photo->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            
            // Movendo o arquivo para a pasta 'profile_photos' dentro do diretório 'public'
            $request->user_photo->move(public_path("profile_photos"), $imageName);
            
            // Atualizando o campo 'user_photo' no banco de dados com o novo nome do arquivo
            $request->user()->user_photo = $imageName;
        }
        

        // Salva o usuário atualizado
        $request->user()->save();

        // Atualiza os telefones
        if ($request->has('phones')) {
            // Deleta os telefones antigos
            $request->user()->phones()->delete();

            // Salva os novos telefones
            foreach ($request->input('phones') as $phoneNumber) {
                $request->user()->phones()->create([
                    'user_phone' => $phoneNumber,
                ]);
            }

        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }




    /**
     * Delete the user's account.
     */

public function destroy(Request $request): RedirectResponse
{
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    // Certifique-se de usar o guard correto
    Auth::guard('web')->logout();

    // Atualiza o status do usuário para 'INATIVO'
    $updated = $user->update(['user_status' => 'INATIVO']);

    // Se a atualização do status foi bem-sucedida, faça logout e invalidar a sessão
    if ($updated) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Adicione uma mensagem flash para o usuário
        session()->flash('status', 'Sua conta foi desativada com sucesso.');

        // Redireciona para a página inicial ou outra página
        return Redirect::to('/')->with('status', 'Conta desativada');
    }

    // Caso contrário, redireciona com uma mensagem de erro
    return Redirect::back()->withErrors(['status' => 'Houve um erro ao desativar sua conta.']);
}


}
