<?php

namespace App\Http\Controllers;
use App\Models\Cotizacion;
use App\Models\CotizacionDetail;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CotizacionRequest;
// use App\Mail\EnviarCotizacionesMailable;
use Mail;
use DB;
use PDF;
use View;


use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    protected $terminosDefault = '
        Validity of quotation .- 15 days
        Payment 30 days ... - Currency MXP
        *Purchase order delay may affect delivery time*
    ';
    public function index()
    {
        try {
            // $this->send_mail('ONE MFG', 'pahr9894.kf@gmail.com', 2);
        } catch (\Exception $e) {
            dd($e);
        }
        $cotizaciones = $this->getCotizacions();
        $userId = auth()->id();
        // dd($userId);
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


    public function store ( CotizacionRequest $request )
    {
        try {
            DB::beginTransaction();
            $userId = $this->getSessionUserId();
            $company_id = $this->getSessionCompanyId();
            $cotizacionHeader = Cotizacion::create([
                "cliente_id" => $request->cliente_id,
                "company_id" => $company_id,
                "status_id" => 1,
                "created_by" => $userId,
                "atencion" => $request->atencion,
                "terminos" => $request->terminos
            ]);
              // Decodificar los detalles de la solicitud JSON
    $requestDetails = json_decode($request->details);
    // dd($request->all(), $requestDetails);
    // Validar los detalles
    foreach ($requestDetails as $detail) {
        $validator = Validator::make((array) $detail, [
            'producto_id' => 'required',
            'precio' => 'required|numeric|min:1',
            'cantidad' => 'required|numeric|min:1',
            'importe' => 'required|numeric|min:1',
            'comentario' => 'max:149'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Crear el objeto CotizacionDetail si la validación pasa
        CotizacionDetail::create([
            "cotizacion_id" => $cotizacionHeader->id,
            "producto_id" => $detail->producto_id,
            "cantidad" => $detail->cantidad,
            "precio" => $detail->precio,
            "importe" => $detail->importe,
            "comentario" => $detail->comentario
        ]);
    }

            DB::commit();
            return response()->json([ 'cotizacion_id' => $cotizacionHeader->id, 'message' => 'Cotizacion creada con éxito',  "type" => 'success'], 201);
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

    public function getSessionUserId(){
        $userId = auth()->id();
        return $userId;
    }

    public function getSessionCompanyId(){
        $company_id = session('opcion_seleccionada');
        return $company_id;
    }

    public function generatePDF()
    {
        // Renderiza la vista Blade a HTML
        $html = view('nombre_de_tu_vista_blade')->render();

        // Genera el PDF usando DOMPDF
        $pdf = PDF::loadHTML($html);

        // Obtén el contenido PDF como una cadena
        $pdfContent = $pdf->output();

        // Convierte el contenido PDF a base64 para enviarlo como JSON
        $pdfBase64 = base64_encode($pdfContent);

        // Devuelve el PDF como una respuesta JSON
        return response()->json(['pdf' => $pdfBase64]);
    }

    public function enviarPDFPorCorreo(Request $request)
{
    // Generar el PDF como se mencionó anteriormente

    // Enviar el PDF como adjunto por correo
    $pdfContent = $pdf->output();

    Mail::to('pahr9894.kf@gmail.com')->send(new EnviarCotizacionesMailable($pdfContent));

    return response()->json(['message' => 'PDF enviado por correo']);
}


public function generarPDFyEnviarCorreo()
{
    // Crear una instancia de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Renderiza la vista Blade a HTML
    $html = view('emails.cotizaciones')->render();

    // Carga el HTML en Dompdf
    $dompdf->loadHtml($html);

    // Establece el tamaño de página y la orientación (por ejemplo, A4 y retrato)
    $dompdf->setPaper('A4', 'portrait');

    // Renderiza el PDF
    $dompdf->render();

    // Obtiene el contenido del PDF como una cadena de bytes
    $pdfContent = $dompdf->output();

    // Envía el correo electrónico con el PDF adjunto
    Mail::to('pahr9894.kf@gmail.com')->send(new EnviarCotizacionesMailable($pdfContent));

    return response()->json(['message' => 'PDF generado y enviado por correo']);
}

public function send_mail( $nombreEmpresa, $to, $cotizacion_id )
{
    $data["email"] = $to;
        $data["title"] = "De {$nombreEmpresa}";
        $data["body"] = "";
        $cotizacionheader = Cotizacion::where('cotizacion.id', $cotizacion_id)
        ->join('clientes AS c', 'c.id', 'cotizacion.cliente_id')
        ->selectRaw("c.nombre, c.direccion, c.codigo_postal, c.image_path, c.correo, c.telefono, cotizacion.*")
        ->first();

    $detail = CotizacionDetail::select([
        "cotizacion_details.id",
        "cotizacion_details.cotizacion_id",
        "cotizacion_details.producto_id",
        "cotizacion_details.cantidad",
        "cotizacion_details.precio",
        "cotizacion_details.comentario",
        "cotizacion_details.importe",
        "p.clave"
    ])
    ->join('productos AS p', function($join){
          $join->on('p.id', 'cotizacion_details.producto_id');
    })
    ->where('cotizacion_id', $cotizacion_id)
    ->get();
    $data_html = [
        "header" => $cotizacionheader,
        "detail" => $detail
    ];
        $pdf = PDF::loadView('emails.cotizaciones-send', $data_html);
        $pdfContent = $pdf->output();
        $pdfBase64 = base64_encode($pdfContent);
        // dd($pdfBase64);


        // Mail::send('emails.email', $data, function($message)use($data, $pdfContent) {
        //     $message->to($data["email"], $data["email"])
        //             ->subject($data["title"])
        //             ->attachData($pdfContent, 'cotizacion.pdf');
        // });

        // dd('Mail sent successfully');
        return response()->json([ "type" => "success", "msg" => "success" ]);
}

public function getCotizacionPDF( Request $request ){
    // dd($request->all());
    $cotizacionheader = Cotizacion::where('cotizacion.id',$request->cotizacion_id)
        ->join('clientes AS c', 'c.id', 'cotizacion.cliente_id')
        ->selectRaw("c.nombre, c.direccion, c.codigo_postal, c.image_path, c.correo, c.telefono, cotizacion.*")
        ->first();

    $detail = CotizacionDetail::select([
        "cotizacion_details.id",
        "cotizacion_details.cotizacion_id",
        "cotizacion_details.producto_id",
        "cotizacion_details.cantidad",
        "cotizacion_details.precio",
        "cotizacion_details.comentario",
        "cotizacion_details.importe",
        "p.clave"
    ])
    ->join('productos AS p', function($join){
          $join->on('p.id', 'cotizacion_details.producto_id');
    })
    ->where('cotizacion_id', $request->cotizacion_id)
    ->get();
    $data = [
        "header" => $cotizacionheader,
        "detail" => $detail
    ];
    $view = View::make('emails.cotizaciones');
    $view->data_html = $data;
    $html = $view->render();
    $res = [
        "html" => $html,
        "type" => "success",
        "Data obtenida correctamente"
    ];
    return response()->json($res);
}

public function indexEdit( Cotizacion $cotizacion_id )
{
    return view('cotizaciones.indexEdit', compact('cotizacion_id'));
}

public function getCotizacionDetails( Request $request ){
    $detail = CotizacionDetail::select([
        "cotizacion_details.id",
        "cotizacion_details.cotizacion_id",
        "cotizacion_details.producto_id",
        "cotizacion_details.cantidad",
        "cotizacion_details.precio",
        "cotizacion_details.comentario",
        "cotizacion_details.importe",
        "p.clave"
    ])
    ->join('productos AS p', function($join){
          $join->on('p.id', 'cotizacion_details.producto_id');
    })
    ->where('cotizacion_id', $request->cotizacion_id)
    ->get();
    return response()->json($detail);
}

public function update ( CotizacionRequest $request ){
        #edita la cotizacion
        try {
            DB::beginTransaction();
            $userId = $this->getSessionUserId();
            $company_id = $this->getSessionCompanyId();
            $cotizacion_id = $request->cotizacion_id;
            $cotizacion = Cotizacion::find( $cotizacion_id );
            // dd($request->all(), $request->cliente_id);
            $cotizacion->cliente_id = intval($request->cliente_id);
            $cotizacion->company_id =$company_id;
            $cotizacion->status_id = 1;
            $cotizacion->created_by = $userId;
            $cotizacion->atencion = $request->atencion;
            $cotizacion->terminos = $request->terminos;
            $cotizacion->save();
             // Obtener los IDs de productos existentes para el detalle de factura
            $existingProductIds = CotizacionDetail::where('cotizacion_id', $cotizacion_id)->pluck('id')->toArray();

            // Decodificar los detalles de la solicitud JSON
            $requestDetails = json_decode($request->details);
            $updatedProducts = [];
            // dd($request->all(), $requestDetails);
            // Validar los detalles
            foreach ($requestDetails as $detail) {
                $validator = Validator::make((array) $detail, [
                    'producto_id' => 'required',
                    'precio' => 'required|numeric|min:1',
                    'cantidad' => 'required|numeric|min:1',
                    'importe' => 'required|numeric|min:1',
                    'comentario' => 'max:149'
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                if( in_array($detail->id, $existingProductIds) ){
                    $cotizacionDetail = CotizacionDetail::find($detail->id);
                    $cotizacionDetail->cotizacion_id = $cotizacion_id;
                    $cotizacionDetail->producto_id = $detail->producto_id;
                    $cotizacionDetail->cantidad = $detail->cantidad;
                    $cotizacionDetail->precio = $detail->precio;
                    $cotizacionDetail->importe = $detail->importe;
                    $cotizacionDetail->comentario = $detail->comentario;
                    $cotizacionDetail->save();
                    $updatedProducts [] ['id'] =  $cotizacionDetail->id;
                }else
                {
                    $cotizacionDetail = CotizacionDetail::create([
                        "cotizacion_id" => $cotizacion_id,
                        "producto_id" => $detail->producto_id,
                        "cantidad" => $detail->cantidad,
                        "precio" => $detail->precio,
                        "importe" => $detail->importe,
                        "comentario" => $detail->comentario
                    ]);
                    $updatedProducts [] ['id'] =   $cotizacionDetail->id;
                    // array_push( 'producto_id' => $updatedProducts, $detail->producto_id);
                }
            }
            CotizacionDetail::where('cotizacion_id', $cotizacion_id)
                ->whereNotIn('id', array_column($updatedProducts, 'id'))
                ->delete();

            DB::commit();
            return response()->json([ 'cotizacion_id' => $cotizacion_id,  'message' => 'Cotizacion editada con éxito',  "type" => 'success'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error en => '.$e->getMessage(), 'line' => $e->getLine(), "type" => 'error'], 400);
        }
}



}
