<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('# Cotización') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Cliente') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Fecha') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Total') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Status') }}
            </th>
            <th class="px-6 py-3 bg-gray-50"></th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('PDF') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Enviar') }}
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($cotizaciones as $cotizacion)
        <tr>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $cotizacion->cotizacion_id }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $cotizacion->nombre_cli }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $cotizacion->fecha }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $cotizacion->total }} </td>
            <td class="px-6 py-4 whitespace-no-wrap">  </td>
            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                <div class="relative inline-block text-left">
                    <button type="button" class="group relative w-8 h-8 bg-gray-200 rounded-full border border-gray-300 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Opciones</span>
                        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-transform transform scale-0 group-hover:scale-100">
                            <!-- Ícono de desplegable (puedes usar otro icono que prefieras) -->
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.293 5.293a1 1 0 011.414 0L10 10.586l5.293-5.293a1 1 0 111.414 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </button>

                    <!-- Menú desplegable (agregado con JavaScript) -->
                    <ul id="menu" class="hidden absolute z-10 mt-2 space-y-2 bg-white border border-gray-300 rounded-lg shadow-lg bottom-full">
                        <li>
                            <a href="{{ route('cotizaciones.edit', ['cotizacion_id' => $cotizacion->cotizacion_id]) }}"  class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Editar</a>
                        </li>
                        <li>
                            <a href="#" onclick="confirmDeleteCotizacion({{$cotizacion->cotizacion_id}})"  class="block px-4 py-2 text-red-600 hover:bg-gray-100">Eliminar</a>
                        </li>
                    </ul>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap">
                <button href="#"
                onclick="getpdf({{$cotizacion->cotizacion_id}})"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Ver PDF
                </button>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap">
                <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Enviar PDF</a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
