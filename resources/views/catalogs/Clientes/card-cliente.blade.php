<div class="bg-white shadow-md rounded-lg overflow-hidden flex">
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
</div>
