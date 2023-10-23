<?php

namespace App\Http\Controllers;
use App\Models\Producto;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    protected $carpeta_destino_products = 'catalogs/products';

    public function index()
    {
        $company_id = intval($this->getSessionCompanyId());
        $products = Producto::where('company_id', $company_id)->get();
        if ( intval(auth()->user()->rol_id) == 1 )
        {
            $products = Producto::get();
        }
        $image_not_found = asset('assets/onemfg_logo.png') ;
        return view('catalogs.Products.list', compact('products', 'image_not_found', 'company_id'));
    }

    public function store(Request $request)
    {
        try {
            $company_id = intval($this->getSessionCompanyId());
            $request->validate([
                'clave' => 'required|string|max:10',
                'descripcion' => 'required|string|max:200',
                'precio' => 'required|numeric|min:0',
                //'file-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if( isset($request->company_id) ){
                $company_id = $request->company_id;
            }

            if( $request->productid <= 0 ){
                $producto = Producto::create([
                    'clave' => $request->input('clave'),
                    'descripcion' => $request->input('descripcion'),
                    'precio' => $request->input('precio'),
                    'company_id' => $company_id
                ]);
                $this->storeProductImage($producto, $request);
                return response()->json(['message' => 'Producto creado con éxito', "type" => 'success'], 200);
            }else{
                $producto = Producto::find($request->productid);
                $producto->clave = $request->clave;
                $producto->descripcion = $request->descripcion;
                $producto->precio = $request->precio;
                $producto->company_id = $company_id;
                $producto->save();
                $this->storeProductImage($producto, $request);
                return response()->json(['message' => 'Producto actualizado con éxito',  "type" => 'success'], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => "Error en => {$e->getMessage()}", "type" => "error"], 400);
        }
    }

    public function storeProductImage( $producto, $request )
    {
        if ($request->hasFile('file-upload')) {
            $image = $request->file('file-upload');
            $fileName = $producto->id . '.' . $image->getClientOriginalExtension();
            // Almacena la imagen en la carpeta 'storage/app/public'
            $image->storeAs('public', $fileName);
            $producto->image_path = $fileName;
            $producto->save();
        }
        return $producto;
    }

    public function destroy( Request $request )
    {
        try {
            $producto = Producto::find($request->productId);
            $producto->delete();
            return response()->json(['message' => 'Eliminado Correctamente', "type" => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error en => {$e->getMessage()}", "type" => "error"], 400);
        }
    }

    public function getproductsforcotizacion(){

        $company_id = intval($this->getSessionCompanyId());
        $products = Producto::select([
            "id as producto_id",
            "clave"
        ])
        ->where('company_id', $company_id)
        ->get();
        return $products;
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
