@extends('layouts.app')

@section('content')
{{-- <form action="{{ route('selected-products.store') }}" method="post"> --}}
    @csrf
    <div class="mb-4">
        <label for="product_ids" class="block font-semibold">Seleccionar Productos:</label>
        <select name="product_ids[]" id="product_ids" class="border rounded p-2 w-full" multiple>
            {{-- @foreach ($products as $product) --}}
                <option value="1">uwu</option>
            {{-- @endforeach --}}
        </select>
        @error('product_ids')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Agregar Productos</button>
{{-- </form> --}}
@stop   

{{-- 
    -App de cotizaciones
Seran 2 empresas en una, al iniciar sesion, se va a seleccionar la empresa con la que se va a trabajar

·Catalogo de clientes
.Catalogo de usuarios
.Catalogo de productos
.Catalogo de empresasa

Serà una vista principal con botones de imagenes de cotizacion, la vista de la cotizacion, clientes, usuarios, productos y empresas, seràn cards con sus imagenes bonitas, no datatables

Usaras datatables u otro framework para la creacion de cotizaciones con sus productos

sesion para guardar el id del empleado que ingreso
pero sanctum u otro framework para las sesiones, igual las vez en el curso

tailwind para un buen diseño
dompdf para los reportes de cotizacion enviados por correo
    
    
    --}}