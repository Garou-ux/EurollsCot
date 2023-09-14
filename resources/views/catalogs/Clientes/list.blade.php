<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/fc-4.3.0/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.0/rr-1.4.1/sc-2.2.0/sb-1.5.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/fc-4.3.0/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.0/rr-1.4.1/sc-2.2.0/sb-1.5.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado de Clientes') }}
        </h2>

    </x-slot>
    <div class="max-w-screen-lg mx-auto p-4">
        {{-- <h1 class="text-2xl font-semibold mb-4">Lista de Productos</h1> --}}
        <div class="flex-grow p-4">
            <button id="openCreateModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                {{ __('Crear Cliente') }}
            </button>
            <br></br>
            <div class="div"></div>
        </div>
        {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"> --}}
                {{-- @foreach ($clientes as $cliente) --}}
                    @include('catalogs.Clientes.card-cliente')
                {{-- @endforeach --}}

        {{-- </div> --}}
    </div>
    @include('catalogs.Clientes.modal-cliente')
    <input type="hidden" value="{{ route('clientes.store') }}" id="url_store_cliente">
    <input type="hidden" value="{{ route('clientes.destroy') }}" id="url_delete_cliente">
    <script type="text/javascript" src="{{ asset('js/ClientesController.js') }}"></script>
</x-app-layout>
