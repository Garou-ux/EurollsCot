<?php

namespace App\Http\Controllers;
use App\Models\Cotizacion;
use App\Models\CotizacionDetail;
use Illuminate\Support\Facades\Validator;
use DB;

use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    public function index()
    {
        $cotizaciones = $this->getCotizacions();
        return view('cotizaciones.index', compact('cotizaciones'));
    }


    #vista para crear la cotizacion
    public function create()
    {
        return view('cotizaciones.new-cotizacion');
    }

    public function getCotizacions(){
        $cotizaciones = Cotizacion::
                        select([
                            "cotizacion.id AS cotizacion_id",
                            "cli.nombre AS nombre_cli",
                            "cli.direccion AS direccion_cli",
                            "cli.codigo_postal AS codigo_postal_cli",
                            "comp.name AS nombre_comp",
                            "comp.direccion AS direccion_comp",
                            "comp.codigo_postal AS codigo_postal_comp",
                            "cotizacion.created_at AS fecha",
                            DB::raw("sum(cd.cantidad) * sum(cd.precio) AS total")
                        ])
                        ->join('cotizacion_details AS cd', function($join){
                            $join->on('cd.cotizacion_id', 'cotizacion.id')
                                 ->whereNull('cd.deleted_at');
                        })
                        ->join('clientes AS cli', function($join){
                            $join->on('cli.id', 'cotizacion.cliente_id')
                                 ->whereNull('cli.deleted_at');
                        })
                        ->join('companies AS comp', function($join){
                            $join->on('comp.id', 'cotizacion.company_id')
                                 ->whereNull('comp.deleted_at');
                        })
                        ->groupBy([
                            'cotizacion.id', 'cli.nombre', 'cli.direccion', 'cli.codigo_postal', 'comp.name', 'comp.direccion', 'comp.codigo_postal', 'cotizacion.created_at'
                        ])
                        ->orderBy('cotizacion.created_at', 'asc')
                        ->get();
        return $cotizaciones;
    }


    public function store ( Request $request )
    {
        try {
            DB::beginTransaction();
            $cotizacionHeader = Cotizacion::create([
                "cliente_id" => $request->cliente_id,
                "company_id" => 1,
                "status_id" => 1,
                "atencion" => $request->atencion
            ]);
              // Decodificar los detalles de la solicitud JSON
    $requestDetails = json_decode($request->details);

    // Validar los detalles
    foreach ($requestDetails as $detail) {
        $validator = Validator::make((array) $detail, [
            'producto' => 'required',
            'precio' => 'required|numeric|min:1',
            'cantidad' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Crear el objeto CotizacionDetail si la validación pasa
        CotizacionDetail::create([
            "cotizacion_id" => $cotizacionHeader->id,
            "producto_id" => $detail->producto,
            "cantidad" => $detail->cantidad,
            "precio" => $detail->precio,
            "importe" => $detail->cantidad * $detail->precio
        ]);
    }

            DB::commit();
            return response()->json(['message' => 'Cotizacion creada con éxito',  "type" => 'success'], 201);
          } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error en => '.$e->getMessage(),  "type" => 'error'], 400);
          }
    }

    public function destroy ( Request $request )
    {
        try {
            DB::beginTransaction();
            $cotizacion = Cotizacion::find($request->cotizacionId);
            $cotizacion->delete();

            CotizacionDetail::where('cotizacion_id', $cotizacion->id)->delete();
            DB::commit();
            return response()->json(['message' => 'Cotizacion eliminada con éxito',  "type" => 'success'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error en => ',  "type" => 'error'], 400);
        }
    }



}
