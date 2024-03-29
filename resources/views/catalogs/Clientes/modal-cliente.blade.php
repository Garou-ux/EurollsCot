<div id="createModal"
    class="fixed inset-0 flex items-center justify-center z-50 hidden"
    style="overflow-y: auto;"
>
    <div class="bg-black opacity-50 inset-0 fixed z-40"></div>
    <div class="bg-white p-4 md:p-8 rounded shadow-lg w-full md:w-96 sm:w-full xs:w-full z-50 relative overflow-y-auto max-h-screen">
        <button id="closeCreateModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="text-xl font-semibold mb-4">Crear Cliente</h2>
        <form id="createForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Foto del Cliente</label>
                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-4 md:py-10">
                    <div class="text-center">
                        <input type="hidden" value="0" id="clienteId">
                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011..5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                <span>Carga una imagen</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                        <p id="image-name" class="text-xs leading-5 text-gray-600"></p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="clave" class="block text-gray-800 font-semibold">Nombre</label>
                <input type="text" name="nombre" id="nombre" maxlength="80"  class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block text-gray-800 font-semibold">Correo</label>
                <input type="text" name="correo" maxlength="40"  id="correo" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for "direccion" class="block text-gray-800 font-semibold">Direccion</label>
                <input type="text" maxlength="300"  name="direccion" id="direccion" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div class="mb-2">
                <label for="codigo_postal" class="block text-gray-800 font-semibold">Codigo Postal</label>
                <input type="number" maxlength="8" name="codigo_postal" id="codigo_postal" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="telefono" class="block text-gray-800 font-semibold">Telefono</label>
                <input type="number" maxlength="40" name="telefono" id="telefono" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            @php
            $user = auth()->user();
            @endphp
            @if ( intval($user->rol_id) == 1 )
            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-4">Selecciona un empresa</h2>
                <select id="company_id" name="company_id" class="block w-full px-4 py-2 border rounded-lg mb-4">
                    <option value="1">One MFG</option>
                    <option value="2">Prescision Manufacturing</option>
                </select>
            </div>
            @endif
            <button type="button" onclick="saveEditClient(this)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Guardar</button>
        </form>
    </div>
</div>
