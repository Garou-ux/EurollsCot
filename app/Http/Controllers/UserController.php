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
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    //
    public function index()
    {
        $company_id = $this->getSessionCompanyId();
        $users = User::get();
        if ( intval(auth()->user()->rol_id) )
        {
            return redirect()->route('login');
        }
        return view('Catalogs.Users.list', compact('users', 'company_id'));
    }
    public function create()
    {
        if ( intval(auth()->user()->rol_id) )
        {
            return redirect()->route('login');
        }
        return view('catalogs.Users.new-user');
    }


    public function storeds(CreateUserRequest $request)
    {
        try {

            $company_id = $this->getSessionCompanyId();
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
                'rol_id' => $request->rol_id,
                'company_id' => $company_id
            ]);

            return response()->json([ 'user' => $user, 'message' => 'success', 'type' => 'success' ]);
        } catch (\Exception $e) {
            return response()->json([ 'message' => $e->getMessage() , 'type' => 'error', 'line' => $e->getLine() ]);
        }
    }
    public function edit(User $user)
    {
        if ( intval(auth()->user()->rol_id) )
        {
            return redirect()->route('login');
        }
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


    public function getSessionCompanyId(){
        $company_id = session('opcion_seleccionada');
        return $company_id;
    }

    public function getSessionUserId(){
        $userId = auth()->id();
        return $userId;
    }
}
