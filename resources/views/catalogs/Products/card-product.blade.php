

<table class="min-w-full divide-y divide-gray-200" id="tblProducts">
    <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Imagen') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Clave') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Descripciom') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Precio') }}
            </th>
            @if ( intval(auth()->user()->rol_id) == 1  )
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Empresa') }}
                </th>
            @endif
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Editar') }}
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Eliminar') }}
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($products as $product)
        <tr>
            <td class="px-6 py-4 whitespace-no-wrap">
                <img src="{{ $product->image_path != null  ? asset('storage/' . $product->image_path) : $image_not_found  }}" alt="Logo" class="w-16 h-16 rounded">
            </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{ $product->clave  }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> {{$product->descripcion }} </td>
            <td class="px-6 py-4 whitespace-no-wrap"> <p class="text-gray-700 font-semibold mt-2"> <small> Precio: </small>${{ number_format($product->precio, 2) }}</p> </td>
            @if ( intval(auth()->user()->rol_id) == 1  )
                @if ( intval($product->company_id) == 1)
                    <td class="px-6 py-4 whitespace-no-wrap">
                        {{ __('ONE MFG')  }}
                    </td>
                @else
                    <td class="px-6 py-4 whitespace-no-wrap">
                    {{ __('PRESCISION MANUFACTURING') }}
                    </td>
                @endif
            @endif
            <td class="px-6 py-4 whitespace-no-wrap">
                <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                data-productid = "{{ $product->id }}"
                data-image_path = "{{ $product->image_path }}"
                data-clave = "{{ $product->clave }}"
                data-descripcion = "{{ $product->descripcion }}"
                data-precio = " {{ $product->precio }} "
                onclick="openModalProduct( this )"
                >
                 Editar
                </a>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap">
                <a href="#"
                onclick="confirmDeleteProduct({{ $product->id }})"
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
