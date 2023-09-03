<?php

namespace App\Http\Controllers;
use App\Models\Cliente;

use Illuminate\Http\Request;

class ClientesController extends Controller
{
    //

    public function index()
    {
        $clientes = Cliente::all();
        $image_not_found = asset('assets/onemfg_logo.png') ;
        return view('catalogs.Clientes.list', compact('clientes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'codigo_postal' => 'required|numeric|min:0',
                'correo' => 'required|string|max:50',
                'telefono' => 'required|numeric|min:0',
                //'file-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if( $request->clienteId <= 0 ){
                $cliente = Cliente::create([
                    'nombre' => $request->input('nombre'),
                    'direccion' => $request->input('direccion'),
                    'codigo_postal' => $request->input('codigo_postal'),
                    'correo' => $request->input('correo'),
                    'telefono' => $request->input('telefono')
                ]);
                $this->storeClientImage($cliente, $request);
                return response()->json(['message' => 'Cliente creado con éxito', "type" => 'success'], 200);
            }else{
                $cliente = Cliente::find($request->clienteId);
                $cliente->nombre = $request->nombre;
                $cliente->direccion = $request->direccion;
                $cliente->codigo_postal = $request->codigo_postal;
                $cliente->correo = $request->correo;
                $cliente->telefono = $request->telefono;
                $cliente->save();
                $this->storeClientImage($cliente, $request);
                return response()->json(['message' => 'Cliente actualizado con éxito',  "type" => 'success'], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => "Error en => {$e->getMessage()}", "type" => "error"], 400);
        }
    }

    public function storeClientImage( $cliente, $request )
    {
        if ($request->hasFile('file-upload')) {
            $image = $request->file('file-upload');
            $fileName = $cliente->id . '.' . $image->getClientOriginalExtension();
            // Almacena la imagen en la carpeta 'storage/app/public'
            $image->storeAs('public/clients', $fileName);
            $cliente->image_path = $fileName;
            $cliente->save();
        }
        return $cliente;
    }

    public function destroy( Request $request )
    {
        try {
            $cliente = Cliente::find($request->clienteId);
            $cliente->delete();
            return response()->json(['message' => 'Eliminado Correctamente', "type" => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error en => {$e->getMessage()}", "type" => "error"], 400);
        }
    }

    public function getclientesforcotizacion(){
        return Cliente::all();
    }
}
