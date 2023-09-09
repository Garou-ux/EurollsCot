<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpcionController extends Controller
{
    //

    public function guardarOpcion(Request $request)
{
    $opcion = $request->input('opcion');
    session(['opcion_seleccionada' => $opcion]);

    return response()->json(['success' => true]);
}

}
