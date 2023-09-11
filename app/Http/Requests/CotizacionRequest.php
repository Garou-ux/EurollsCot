<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CotizacionRequest extends FormRequest
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
            'cliente_id' => 'required',
            Rule::exists('clientes', 'id'),
            'atencion' => 'required|max:50',
            'terminos' => 'required'
        ];
    }

    public function messages(){
        return [
            'cliente_id.exists' => 'El cliente seleccionado no existe en nuestra base de datos.',
            'terminos.required' => 'Los terminos son necesarios',
            'atencion' => 'El campo de atencion es necesario'
        ];
    }
}
