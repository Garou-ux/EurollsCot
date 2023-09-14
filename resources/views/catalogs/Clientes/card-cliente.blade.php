{{-- <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
    <img src="{{ $cliente->image_path != null  ? asset('storage/clients/' . $cliente->image_path) : $image_not_found  }}" alt="Logo" class="w-16 h-16 rounded">
    <div class="flex-grow p-4">
        <h2 class="text-xl font-semibold mb-2"> <small> Nombre: </small> {{ $cliente->nombre }}</h2>
        <p class="text-gray-600"> <small> Correo: </small>{{ $cliente->correo }}</p>
        <p class="text-gray-700 font-semibold mt-2"> <small> Telefono: </small> {{ $cliente->telefono }} </p>
    </div>
    <div class="flex flex-col justify-end space-y-2 p-4">
        <button
            type="button"
            class="text-blue-600 hover:underline"
            data-clienteId = "{{ $cliente->id }}"
            data-image_path = "{{ $cliente->image_path }}"
            data-nombre = "{{ $cliente->nombre }}"
            data-direccion = "{{ $cliente->direccion }}"
            data-codigo_postal = " {{ $cliente->codigo_postal }} "
            data-correo = "{{ $cliente->correo }}"
            data-telefono = "{{ $cliente->telefono }}"
            onclick="openModalClients( this )"
        >
            Editar
        </button>

        <button
            type="button"
            class="text-red-600 hover:underline"
            onclick="confirmDeleteClient({{ $cliente->id }})"
        >
            Eliminar
        </button>
    </div>
</div> --}}




<table class="min-w-full divide-y divide-gray-200" id="tblProducts">
    <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Imagen') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Nombre') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Correo') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Telefono') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Editar') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Eliminar') }}
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($clientes as $cliente)
        <tr>
            <td class="px-6 py-4 whitespace-no-wrap">
                <img src="{{ $cliente->image_path != null  ? asset('storage/clients/' . $cliente->image_path) : $image_not_found  }}" alt="Logo" class="w-16 h-16 rounded">
            </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $cliente->nombre  }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{$cliente->correo }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $cliente->telefono }} </td>
            {{-- <td class="px-6 py-4 whitespace-no-wrap">  </td> --}}
            <td class="px-6 py-4 whitespace-no-wrap">
                <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                data-clienteId = "{{ $cliente->id }}"
                data-image_path = "{{ $cliente->image_path }}"
                data-nombre = "{{ $cliente->nombre }}"
                data-direccion = "{{ $cliente->direccion }}"
                data-codigo_postal = " {{ $cliente->codigo_postal }} "
                data-correo = "{{ $cliente->correo }}"
                data-telefono = "{{ $cliente->telefono }}"
                onclick="openModalClients( this )"
                >
                 Editar
                </a>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap">
                <a href="#"
                onclick="confirmDeleteClient({{ $cliente->id }})"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
               Eliminar
            </a>
            </td>
            {{-- <td class="px-6 py-4 whitespace-no-wrap">
                <button
                    type="button"
                    class="text-blue-600 hover:underline"
                    data-productid = "{{ $product->id }}"
                    data-image_path = "{{ $product->image_path }}"
                    data-clave = "{{ $product->clave }}"
                    data-descripcion = "{{ $product->descripcion }}"
                    data-precio = " {{ $product->precio }} "
                    onclick="openModalProduct( this )"
                >
                    Editar
                </button>
            </td> --}}
            {{-- <td class="px-6 py-4 whitespace-no-wrap">
                <button
                    type="button"
                    class="text-red-600 hover:underline"
                    onclick="confirmDeleteProduct({{ $product->id }})"
                >
                    Eliminar
                </button>
            </td> --}}
        </tr>
        @endforeach
    </tbody>
</table>
