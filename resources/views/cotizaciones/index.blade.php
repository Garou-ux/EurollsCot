<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado de Cotizaciones') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a
                    href="{{ route('cotizaciones.create') }}"
                    {{-- href="#" --}}
                     class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        {{ __('Crear Cotizacion') }}
                    </a>
                    <br></br>
                    <div class="div"></div>
                     @include('cotizaciones.row-cotizacion-list')
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{ route('cotizaciones.destroy') }}" id="url_delete_cotizacion">
    <input type="hidden" value="{{ route('cotizaciones.pdf') }}" id="url_get_pdf">

    <script type="text/javascript" src="{{ asset('js/ListCotizacionesController.js') }}"></script>
</x-app-layout>
