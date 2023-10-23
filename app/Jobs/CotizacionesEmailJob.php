<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use PDF;
use Illuminate\Support\Facades\View;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Models\Cotizacion;
use App\Models\CotizacionDetail;
use Dompdf\Options;
use Dompdf\Dompdf;

class CotizacionesEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $cotizacion_id;
    protected $correo;
    public function __construct()
    {
        //
    }

    public function setCotizacionIdParam( $cotizacion_id ){
        $this->cotizacion_id = $cotizacion_id;
    }

    public function setCorreoParam( $correo ){
        $this->correo = $correo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            logger('El trabajo en cola está siendo manejado');
            $this->enviarCorreoConPDF($this->cotizacion_id);

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function failed(\Exception $e){
        print_r("\n Msg:".$e->getMessage());
        print_r("\n File:".$e->getFile());
        print_r("Linea: ".$e->getLine());
    }

    public function enviarCorreoConPDF($cotizacion_id) {
        try {
        //     $cotizacionheader = Cotizacion::where('cotizacion.id',$cotizacion_id)
        //     ->join('clientes AS c', 'c.id', 'cotizacion.cliente_id')
        //     ->selectRaw("c.nombre, c.direccion, c.codigo_postal, c.image_path, c.correo, c.telefono, cotizacion.*")
        //     ->first();

        // $detail = CotizacionDetail::select([
        //     "cotizacion_details.id",
        //     "cotizacion_details.cotizacion_id",
        //     "cotizacion_details.producto_id",
        //     "cotizacion_details.cantidad",
        //     "cotizacion_details.precio",
        //     "cotizacion_details.comentario",
        //     "cotizacion_details.importe",
        //     "p.clave"
        // ])
        // ->join('productos AS p', function($join){
        //     $join->on('p.id', 'cotizacion_details.producto_id');
        // })
        // ->where('cotizacion_id', $cotizacion_id)
        // ->get();

        // $data = [
        //     "header" => $cotizacionheader,
        //     "detail" => $detail
        // ];

        // $header = $cotizacionheader;
        // $correo = $this->correo;
        // $company_id = session('opcion_seleccionada');
        // $options = new Options();
        // $options->set('isPhpEnabled', true);
        // $dompdf = new Dompdf($options);

        // // Genera el PDF
        // $pdf = $dompdf->loadView('emails.cotizaciones', compact('header', 'detail', 'company_id'));
        // Mail::send(['text'=>'emails.mail'], $data, function($message) use( $header, $detail, $correo, $cotizacion_id, $company_id, $pdf){

        //     $message->to($correo)->subject("Cotizacion # {$cotizacion_id}");

        //     $message->from('onemfgmessages@gmail.com', 'One Mfg');

        //     // Adjunta el PDF
        //     $message->attachData($pdf->output(), 'filename.pdf');
        // });
        $cotizacion_id = 15;
        $cotizacionheader = Cotizacion::where('cotizacion.id',15)
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
    ->where('cotizacion_id', 15)
    ->get();

    $data = [
        "header" => $cotizacionheader,
        "detail" => $detail
    ];

    $header = $cotizacionheader;
    $correo = "pahr9894.kf@gmail.com";
    $company_id = session('opcion_seleccionada');
    $options = new Options();
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);
    // dd($header, $detail);
    // Genera el PDF
    $pdf = PDF::loadView('emails.cotizaciones', compact('header', 'detail', 'company_id'));

    // Envía el correo con el PDF adjunto
    Mail::send(['text'=>'emails.mail'], $data, function($message) use( $header, $detail, $correo, $cotizacion_id, $company_id, $pdf){

        $message->to($correo)->subject("Cotizacion # {$cotizacion_id}");

        $message->from('onemfgmessages@gmail.com', 'One Mfg');

        // Adjunta el PDF
        $message->attachData($pdf->output(), 'filename.pdf');
    });
        } catch (\Exception $e) {
            print_r("\n Msg:".$e->getMessage());
            print_r("\n File:".$e->getFile());
            print_r("Linea: ".$e->getLine());
        }

    }
}

