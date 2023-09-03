<x-app-layout>
    <x-slot name="header">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($clientes as $cliente)
                    @include('catalogs.Clientes.card-cliente', [$cliente])
                @endforeach

        </div>
    </div>
    @include('catalogs.Clientes.modal-cliente')
    <input type="hidden" value="{{ route('clientes.store') }}" id="url_store_cliente">
    <input type="hidden" value="{{ route('clientes.destroy') }}" id="url_delete_cliente">
    <script type="text/javascript" src="{{ asset('js/ClientesController.js') }}"></script>
</x-app-layout>
