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
        $products = Producto::all();
        $image_not_found = asset('assets/onemfg_logo.png') ;
        return view('Catalogs.Products.list', compact('products', 'image_not_found'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'clave' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                //'file-upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if( $request->productid <= 0 ){
                $producto = Producto::create([
                    'clave' => $request->input('clave'),
                    'descripcion' => $request->input('descripcion'),
                    'precio' => $request->input('precio'),
                ]);
                $this->storeProductImage($producto, $request);
                return response()->json(['message' => 'Producto creado con éxito', "type" => 'success'], 200);
            }else{
                $producto = Producto::find($request->productid);
                $producto->clave = $request->clave;
                $producto->descripcion = $request->descripcion;
                $producto->precio = $request->precio;
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
        $products = Producto::all();
        return $products;
    }

}
