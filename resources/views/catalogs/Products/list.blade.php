<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado de Productos') }}
        </h2>

    </x-slot>
    <div class="max-w-screen-lg mx-auto p-4">
        {{-- <h1 class="text-2xl font-semibold mb-4">Lista de Productos</h1> --}}
        <div class="flex-grow p-4">
            <button id="openCreateModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                {{ __('Crear Producto') }}
            </button>
            <br></br>
            <div class="div"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($products as $product)
                    @include('catalogs.Products.card-product', [$product])
                @endforeach

        </div>
    </div>
    @include('catalogs.Products.modal-product')
    <input type="hidden" value="{{ route('products.store') }}" id="url_store_product">
    <input type="hidden" value="{{ route('products.destroy') }}" id="url_delete_product">
    <script type="text/javascript" src="{{ asset('js/ProductController.js') }}"></script>
</x-app-layout>
