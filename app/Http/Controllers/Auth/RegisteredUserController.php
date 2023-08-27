<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'paternal_surname' => ['required', 'string', 'max:50'],
            'mother_surname' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:20'],
            'state' => ['required', 'string', 'max:15'],
            'postal_code' => ['required', 'integer', 'max:10'],
            'rol_id' => ['required', 'integer', 'max:5'],

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'paternal_surname' => $request->paternal_surname,
            'mother_surname' => $request->mother_surname,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $postal_code,
            'img_path' => null,
            'rol_id' => $request->rol_id
        ]);

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->route('users.index')->with('success', 'User created successfully');

    }
}
