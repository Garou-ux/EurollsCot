<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogosController extends Controller
{
    //

    public function list( Request $request)
    {
        return view('catalogs.list');
    }
}
