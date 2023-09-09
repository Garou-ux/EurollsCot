<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EnviarPDF;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class EnviosOneMfgController extends Controller
{
    //

    public function enviarPDFPorCorreo()
{
    // Genera el PDF utilizando Dompdf
    $pdf = PDF::loadView('pdf');

    // Envía el PDF por correo utilizando un Mailable personalizado
    $correo = new EnviarPDF($pdf);
    Mail::to('correo_destino@example.com')->send($correo);

    return "PDF enviado por correo correctamente.";
}
}
