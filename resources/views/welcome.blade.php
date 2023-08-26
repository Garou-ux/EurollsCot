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