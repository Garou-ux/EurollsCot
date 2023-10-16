<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('Catalogs.Users.list', compact('users'));
    }
    public function create()
    {
        return view('catalogs.Users.new-user');
    }


    public function storeds(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'paternal_surname' => ['required', 'string', 'max:50'],
                'mother_surname' => ['required', 'string', 'max:50'],
                'address' => ['required', 'string', 'max:50'],
                'city' => ['required', 'string', 'max:20'],
                'state' => ['required', 'string', 'max:15'],
                'postal_code' => ['required', 'max:10'],
                'rol_id' => ['required', 'max:5'],
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
                'postal_code' => $request->postal_code,
                'img_path' => null,
                'rol_id' => $request->rol_id
            ]);

            return response()->json([ 'user' => $user, 'message' => 'success', 'type' => 'success' ]);
        } catch (\Exception $e) {
            return response()->json([ 'message' => $e->getMessage() , 'type' => 'error', 'line' => $e->getLine() ]);
        }
    }
    public function edit(User $user)
    {
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Aquí puedes agregar la lógica para actualizar el usuario existente
        // Utiliza $request->input() para obtener los datos del formulario
        // y luego actualiza el registro correspondiente en la base de datos.
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
