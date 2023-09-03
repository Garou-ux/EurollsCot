<div class="bg-white shadow-md rounded-lg overflow-hidden flex">
    <img src="{{ $product->image_path != null  ? asset('storage/' . $product->image_path) : $image_not_found  }}" alt="Logo" class="w-16 h-16 rounded">
    <div class="flex-grow p-4">
        <h2 class="text-xl font-semibold mb-2"> <small> Clave: </small> {{ $product->clave }}</h2>
        <p class="text-gray-600"> <small> Descripcion: </small>{{ $product->descripcion }}</p>
        <p class="text-gray-700 font-semibold mt-2"> <small> Precio: </small>${{ number_format($product->precio, 2) }}</p>
    </div>
    <div class="flex flex-col justify-end space-y-2 p-4">
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

        <button
            type="button"
            class="text-red-600 hover:underline"
            onclick="confirmDeleteProduct({{ $product->id }})"
        >
            Eliminar
        </button>
    </div>
</div>
