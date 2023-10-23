<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'paternal_surname' => 'required|string|max:50',
            'mother_surname' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'city' => 'required|string|max:20',
            'state' => 'required|string|max:15',
            'postal_code' => 'required|max:10',
            'rol_id' => 'required|max:5',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre de usuario es obligatorio',
            'email.required' => 'El campo de correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida',
            'email.unique' => 'El correo electrónico ya está en uso',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'La confirmación de la contraseña no coincide',
            'password.min' => 'La contraseña debe tener al menos :min caracteres',
            'paternal_surname.required' => 'El apellido paterno es obligatorio',
            'mother_surname.required' => 'El apellido materno es obligatorio',
            'address.required' => 'La dirección es obligatoria',
            'city.required' => 'La ciudad es obligatoria',
            'state.required' => 'El estado es obligatorio',
            'postal_code.required' => 'El código postal es obligatorio',
            'postal_code.max' => 'El código postal no puede tener más de :max caracteres',
            'rol_id.required' => 'El ID del rol es obligatorio',
            'rol_id.max' => 'El ID del rol no puede tener más de :max caracteres',
        ];
    }
}
