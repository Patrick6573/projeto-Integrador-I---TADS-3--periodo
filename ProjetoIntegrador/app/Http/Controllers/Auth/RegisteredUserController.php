<?php

namespace App\Http\Controllers\Auth;
use illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Controllers\UserPhoneController;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        

        $user = User::create([
            'id' => Str::uuid()->toString(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if($request->hasFile('user_photo') && $request->file('user_photo')->isValid() ){

            $extension = $request->user_photo->extension();
            $imageName = md5($request->user_photo->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $request->user_photo->move(public_path("profile_photos"), $imageName);
            $user->user_photo = $imageName;
        }
        $user->save();

        
        event(new Registered($user));
        Auth::login($user);

        //Salvando telefone que o usuario colocou no formulario de registro
        $phoneSave = new UserPhoneController;
        $phoneSave->storePhone($request);

        

        return redirect(route('dashboard', absolute: false));
    }
}
