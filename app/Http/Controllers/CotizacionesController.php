<?php

namespace App\Http\Controllers;
use App\Models\Cotizacion;
use App\Models\CotizacionDetail;

use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    public function index()
    {
        return view('cotizaciones.index');
    }
}
