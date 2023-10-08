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

class CotizacionesEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $cotizacion_id;
    public function __construct()
    {
        //
    }

    public function setCotizacionIdParam( $cotizacion_id ){
        $this->cotizacion_id = $cotizacion_id;
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
        print_r("\n Falla en ".$this->queue);
        print_r("\n Msg:".$e->getMessage());
        print_r("\n File:".$e->getFile());
        print_r("Linea: ".$e->getLine());
    }

    public function enviarCorreoConPDF($cotizacion_id) {
        try {
            $cotizacionheader = Cotizacion::where('cotizacion.id',$cotizacion_id)
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

        $data = [
            "header" => $cotizacionheader,
            "detail" => $detail
        ];

        $header = $cotizacionheader;
        // $view = View::make('emails.cotizaciones', compact('header', 'detail'));
        // $html = $view->render();

        // // Guarda el HTML en una ubicación temporal
        // $htmlPath = storage_path('app/temp_html.html');
        // file_put_contents($htmlPath, $html);

        // // Genera el PDF
        // $pdf = PDF::loadHtml($html);
        // $pdf->setPaper('a4');

        // // Guarda el PDF en una ubicación temporal
        // $pdfPath = storage_path('app/temp_pdf.pdf');
        // $pdf->save($pdfPath);


            // Crear una instancia de Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
                    // Renderiza la vista Blade a HTML
            $html = view('emails.cotizaciones',compact('header', 'detail'))->render();

            // Carga el HTML en Dompdf
            $dompdf->loadHtml($html);

            // Establece el tamaño de página y la orientación (por ejemplo, A4 y retrato)
            $dompdf->setPaper('A4', 'portrait');

            // Renderiza el PDF
            $dompdf->render();

            // Obtiene el contenido del PDF como una cadena de bytes
            $pdfContent = $dompdf->output();
            Mail::raw('Contenido del correo', function ($message) use ($pdfPath,$pdfContent) {
                $message->to('pahr9894.kf@gmail.com')
                    ->subject('Asunto del correo')
                    ->attach($pdfContent, [
                        'as' => 'documento.pdf', // Nombre del archivo adjunto
                        'mime' => 'application/pdf', // Tipo MIME
                    ]);
            });
            // });

            // Borra el archivo temporal (opcional)
            // unlink($pdfPath);
        } catch (\Exception $e) {
            print_r("\n Falla en ".$this->queue);
            print_r("\n Msg:".$e->getMessage());
            print_r("\n File:".$e->getFile());
            print_r("Linea: ".$e->getLine());
        }

    }
}

