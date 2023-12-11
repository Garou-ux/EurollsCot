<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use App\Models\ClientesEmail;

use Illuminate\Http\Request;

class ClientesController extends Controller
{
    //

    public function index()
    {
        $company_id = intval($this->getSessionCompanyId());
        $clientes = Cliente::where('company_id', $company_id)->get();
        if ( intval(auth()->user()->rol_id) == 1 )
        {
            $clientes = Cliente::get();
        }
        $image_not_found = asset('assets/onemfg_logo.png') ;
        return view('catalogs.Clientes.list', compact('clientes', 'image_not_found'));
    }

    public function store(Request $request)
    {
        try {
            $company_id = $this->getSessionCompanyId();
            $userId = $this->getSessionUserId();
            if( isset($request->company_id) ){
                $company_id = $request->company_id;
            }
            $request->validate([
                'nombre' => 'required|string|max:80',
                'direccion' => 'required|string|max:255',
                'codigo_postal' => 'required|numeric|min:0',
                'correo' => 'required|string|max:50',
                'telefono' => 'required|numeric|min:0',
                //'file-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if( $request->clienteId <= 0 ){
                $cliente = Cliente::create([
                    'nombre' => $request->nombre,
                    'direccion' => $request->direccion,
                    'codigo_postal' => $request->codigo_postal,
                    'correo' => $request->correo,
                    'telefono' => $request->telefono,
                    'company_id' => $company_id,
                    'created_by' => $userId
                ]);
                $this->storeClientImage($cliente, $request);
                $this->saveClienteEmail($cliente->id, $cliente->correo);
                return response()->json(['message' => 'Cliente creado con éxito', "type" => 'success'], 200);
            }else{
                $cliente = Cliente::find($request->clienteId);
                $cliente->nombre = $request->nombre;
                $cliente->direccion = $request->direccion;
                $cliente->codigo_postal = $request->codigo_postal;
                $cliente->correo = $request->correo;
                $cliente->telefono = $request->telefono;
                $cliente->company_id = $company_id;
                $cliente->created_by = $userId;
                $cliente->save();
                $this->storeClientImage($cliente, $request);
                $this->saveClienteEmail($cliente->id, $cliente->correo);
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
        $company_id = intval($this->getSessionCompanyId());
        return Cliente::where('company_id', $company_id)->get();
    }

    public function saveClienteEmail( $cliente_id, $correo ){
        $clienteEmail = ClientesEmail::updateOrCreate([
            "cliente_id" => $cliente_id,
            "correo" => $correo
        ], [
            'cliente_id' => $cliente_id,
            'correo' => $correo
        ]);
        return $clienteEmail;
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
