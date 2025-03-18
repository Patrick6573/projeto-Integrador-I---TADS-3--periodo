<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Valida as credenciais de login
        $credentials = $request->only('email', 'password');
    
        // Verifique se o usuário existe e se está inativo
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user && $user->user_status === 'INATIVO') {
            // Caso a conta esteja inativa, redireciona com erro
            return back()->withErrors(['email' => 'Credenciais incorretas.']);
        }
    
        // Realiza a autenticação do usuário
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
    
        // Se as credenciais estiverem incorretas
        return back()->withErrors(['email' => 'As credenciais fornecidas não correspondem aos nossos registros.']);
    }
    
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
