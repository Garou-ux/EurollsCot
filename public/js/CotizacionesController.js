

// import $ from 'jquery';


// document.addEventListener("DOMContentLoaded", function () {
//     const select = document.getElementById("miSelect");

//     // Simulación de datos desde un JSON
//     const jsonData = [
//         { id: 1, text: "Opción 1" },
//         { id: 2, text: "Opción 2" },
//         { id: 3, text: "Opción 3" },
//     ];

//     // Llenar el select con opciones
//     jsonData.forEach((item) => {
//         const option = new Option(item.text, item.id);
//         select.add(option);
//     });

//     // Inicializar Select2 en el elemento select
//     $(select).select2({
//         search: true
//     });


// });

// // Crear el elemento select
// const select = document.createElement('select');
// select.id = 'miSelect';
// select.classList.add('h-6', 'px-3', 'rounded');

// // Agregar opciones al select
// const opciones = ['Opción 1', 'Opción 2', 'Opción 3'];
// opciones.forEach((opcion, index) => {
//     const option = document.createElement('option');
//     option.value = `opcion${index + 1}`;
//     option.text = opcion;
//     select.add(option);
// });

// // Agregar el select al documento
// document.body.appendChild(select);



appControl = appModule;

const url_store_cotizacion = document.getElementById('url_store_cotizacion').value;
const url_get_products = document.getElementById('url_get_products').value;
const url_get_clients = document.getElementById('url_get_clients').value
const selectPicker = document.getElementById('selectPicker');
const searchInput = document.createElement('input');
let rowsData = [];
searchInput.setAttribute('type', 'text');
searchInput.setAttribute('placeholder', 'Buscar Cliente');
let cont = 0;
let _tamaño = 0;
const getProducts = async  () => {
    let response = await appControl.fetchData(url_get_products, {}, 'GET');
    return response;
}

const getClients = async () => {
    let response = await appControl.fetchData(url_get_clients, {}, 'GET');
    return response;
}

document.addEventListener('DOMContentLoaded', async function() {
        const options = await getClients();
        function filterOptions() {
            const searchTerm = searchInput.value.toLowerCase();
            const filteredOptions = options.filter(option =>
            option.nombre.toLowerCase().includes(searchTerm)
            );

            while (selectPicker.options.length > 0) {
            selectPicker.options.remove(0);
            }

            filteredOptions.forEach(option => {
            const newOption = new Option(option.nombre, option.id);
            selectPicker.add(newOption);
            });
        }

        // Agrega el evento de búsqueda
        searchInput.addEventListener('input', filterOptions);
        options.forEach(option => {
            const newOption = new Option(option.nombre, option.id);
            newOption.dataset.id = option.id;
            newOption.dataset.direccion = option.direccion;
            newOption.dataset.codigoPostal = option.codigo_postal;
            // Agrega otros atributos data-* según tus necesidades
            selectPicker.add(newOption);
        });

        // Agrega el buscador
        selectPicker.insertAdjacentElement('beforebegin', searchInput);
        const direccionCli = document.getElementById('direccion_cli');
        const emailCli = document.getElementById('email_cli');
        const codigoPostal = document.getElementById('codigo_postal');

        selectPicker.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption) {
                // Actualiza el contenido de los elementos <p> con los valores del dataset
                direccionCli.textContent = selectedOption.dataset.direccion || '';
                emailCli.textContent = selectedOption.dataset.correo || '';
                codigoPostal.textContent = selectedOption.dataset.codigoPostal || '';
                // Puedes agregar más actualizaciones de elementos <p> según los datos del dataset
            }
        });
        selectPicker.dispatchEvent(new Event('change'));
        const productos = await getProducts();
        const tabla = document.getElementById('miTabla');
        const tbody = document.getElementById('tbody');
        const subtotalElement = document.getElementById('subtotal');
        const ivaElement = document.getElementById('iva');
        const totalElement = document.getElementById('total');
        const agregarFilaButton = document.getElementById('agregarFila');
        const productosSeleccionados = new Set();



        agregarFilaButton.addEventListener('click', agregarFila);
        function agregarFila() {
            const fila = document.createElement('tr');
            fila.classList.add('border-b', 'border-slate-200');
            cont += 1;
            const productoSelectTd = document.createElement('td');
            productoSelectTd.classList.add('py-2', 'pl-4', 'pr-3', 'text-sm', 'sm:pl-6', 'md:pl-0');
            const productoSelect = createSelect('producto', getProductosDisponibles());
            productoSelect.id = cont;
            productoSelect.classList.add('w-full', 'px-2', 'py-1', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:ring', 'focus:ring-blue-500');
            productoSelectTd.appendChild(productoSelect);

            const cantidadInputTd = document.createElement('td');
            cantidadInputTd.classList.add('hidden', 'px-2', 'py-2', 'text-sm', 'text-right', 'text-slate-500', 'sm:table-cell');
            const cantidadInput = createInput('number', 'cantidad', 1);
            cantidadInput.classList.add('w-full', 'px-2', 'py-1', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:ring', 'focus:ring-blue-500');
            cantidadInputTd.appendChild(cantidadInput);

            const precioInputTd = document.createElement('td');
            precioInputTd.classList.add('hidden', 'px-2', 'py-2', 'text-sm', 'text-right', 'text-slate-500', 'sm:table-cell');
            const precioInput = createInput('number', 'precio', 0);
            precioInput.classList.add('w-full', 'px-2', 'py-1', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:ring', 'focus:ring-blue-500');
            precioInputTd.appendChild(precioInput);

            const totalTd = document.createElement('td');
            totalTd.classList.add('py-2', 'pl-3', 'pr-4', 'text-sm', 'text-right', 'text-slate-500', 'sm:pr-6', 'md:pr-0');
            totalTd.textContent = '$0.00';

            const accionesTd = document.createElement('td');
            accionesTd.classList.add("py-2", "pl-4", "pr-3", "text-sm", "sm:pl-6", "md:pl-0", "text-right");
            const eliminarButton = document.createElement('button');
            eliminarButton.textContent = 'Eliminar';
            eliminarButton.classList.add("inline-flex", "items-center", "px-2", "py-2", "bg-red-600", "border", "border-transparent", "rounded-md", "font-semibold", "text-xs", "text-white", "uppercase", "tracking-widest", "hover:bg-red-500", "active:bg-red-700", "focus:outline-none", "focus:ring-2", "focus:ring-red-500", "focus:ring-offset-2");
            eliminarButton.addEventListener('click', () => eliminarFila(fila));
            accionesTd.appendChild(eliminarButton);

            fila.appendChild(productoSelectTd);
            fila.appendChild(cantidadInputTd);
            fila.appendChild(precioInputTd);
            fila.appendChild(totalTd);
            fila.appendChild(accionesTd);

            tbody.appendChild(fila);
            productoSelect.addEventListener('change', () => {
                const productoSeleccionado = Number(productoSelect.value);
                productosSeleccionados.add(productoSeleccionado);
                actualizarProductosDisponibles();
              });
            // Crear objeto de fila y agregarlo a rowsData
            const row = {
                producto: productoSelect,
                cantidad: cantidadInput,
                precio: precioInput,
                total: totalTd,
                eliminarButton: eliminarButton,
            };

            rowsData.push(row);

            productoSelect.addEventListener('change', () => actualizarTotal(row));
            cantidadInput.addEventListener('input', () => actualizarTotal(row));
            precioInput.addEventListener('input', () => actualizarTotal(row));
            $(`#${cont}`).select2({
                search: true
            });
            const elementos = document.querySelectorAll('.select2-container');

            elementos.forEach(elemento => {
                const rect = elemento.getBoundingClientRect();
                // Obtiene el ancho exacto con decimales
                 const anchoExacto = rect.width;
                 console.log(anchoExacto);
                 console.log(elemento, cont, _tamaño);
                if(cont === 1){
                    _tamaño = anchoExacto;
                }
                if ( cont > 1 ){
                    console.log(`${_tamaño}px;`);
                    elemento.style.width = `${_tamaño}px`;
                }
            });
            actualizarTotal();
        }

        function createSelect(name, options) {
            const select = document.createElement('select');
            select.name = name;
            select.classList.add('w-full', 'px-2', 'py-1', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:ring', 'focus:ring-blue-500');

            options.forEach((optionData) => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;
                select.appendChild(option);
            });

            return select;
        }

        function createInput(type, name, value) {
            const input = document.createElement('input');
            input.type = type;
            input.name = name;
            input.value = value;
            input.classList.add('w-full', 'px-2', 'py-1', 'border', 'border-gray-300', 'rounded', 'focus:outline-none', 'focus:ring', 'focus:ring-blue-500');

            return input;
        }


        // Obtener las opciones de productos disponibles excluyendo los seleccionados
function getProductosDisponibles() {
    const opcionesDisponibles = productos.filter((p) => !productosSeleccionados.has(p.id));
    return opcionesDisponibles.map((p) => ({ value: p.id, text: p.clave }));
  }

  // Actualizar las opciones de productos en todos los selects
  function actualizarProductosDisponibles() {
    const selects = document.querySelectorAll('select[name="producto"]');
    selects.forEach((select) => {
      const opcionesDisponibles = getProductosDisponibles();
      const valorSeleccionado = select.value;
      select.innerHTML = '';
      opcionesDisponibles.forEach((opcion) => {
        const option = document.createElement('option');
        option.value = opcion.value;
        option.textContent = opcion.text;
        select.appendChild(option);
      });
      // Mantener el valor seleccionado si aún está disponible
      if (opcionesDisponibles.some((opcion) => opcion.value === valorSeleccionado)) {
        select.value = valorSeleccionado;
      }
    });
  }

  // Eliminar fila y liberar el producto seleccionado
  function eliminarFila(fila) {
    const select = fila.querySelector('select[name="producto"]');
    const productoSeleccionado = select.value;
    productosSeleccionados.delete(productoSeleccionado);
    fila.remove();
    actualizarProductosDisponibles();
    // Resto del código para actualizar totales, etc.
  }

        function actualizarTotal() {
            let subtotal = 0;

            rowsData.forEach((rowData) => {
                const producto = rowData.producto.value;
                const cantidad = parseFloat(rowData.cantidad.value);
                const precio = parseFloat(rowData.precio.value);
                const total = cantidad * precio;

                rowData.total.textContent = '$' + total.toFixed(2);

                subtotal += total;
            });

            const iva = subtotal * 0.16;
            const total = subtotal + iva;

            subtotalElement.textContent = '$' + subtotal.toFixed(2);
            ivaElement.textContent = '$' + iva.toFixed(2);
            totalElement.textContent = '$' + total.toFixed(2);
        }

        function createSelect(name, options) {
            const select = document.createElement('select');
            select.name = name;
            select.classList.add('py-4', 'pl-4', 'pr-3', 'text-sm', 'sm:pl-6', 'md:pl-0', 'bg-white', 'border', 'border-gray-300', 'rounded');

            options.forEach((optionData) => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;
                select.appendChild(option);
            });

            return select;
        }

        function createInput(type, name, value) {
            const input = document.createElement('input');
            input.type = type;
            input.name = name;
            input.value = value;
            input.classList.add('py-4', 'px-3', 'bg-white', 'border', 'border-gray-300', 'rounded');

            return input;
        }

});


//     eliminarButton.classList.add("inline-flex", "items-center", "px-4", "py-2", "bg-red-600", "border", "border-transparent", "rounded-md", "font-semibold", "text-xs", "text-white", "uppercase", "tracking-widest", "hover:bg-red-500", "active:bg-red-700", "focus:outline-none", "focus:ring-2", "focus:ring-red-500", "focus:ring-offset-2");    eliminarButton.addEventListener('click', () => eliminarFila(fila));
const guardarBtn = document.getElementById('guardarBtn');
guardarBtn.addEventListener('click', guardarDatos);

async function guardarDatos() {
    const dataToSend = [];

    // Recorre cada fila de la tabla y recopila los datos
    rowsData.forEach((rowData) => {
        const producto = rowData.producto.value;
        const cantidad = parseFloat(rowData.cantidad.value);
        const precio = parseFloat(rowData.precio.value);
        dataToSend.push({ producto, cantidad, precio });
    });

    let cliente_id = document.getElementById('selectPicker').value;

    let atencion = document.getElementById('atencion').value;
    if(atencion === '' || atencion === undefined){
        Swal.fire('', 'El campo de atencion no puede estar vacio', 'warning');
        return;
    }

    if ( dataToSend.length <= 0 ){
        Swal.fire('', 'Debes de capturar al menos un producto', 'warning');
        return;
    }


    let data = {
        _token: document.getElementById('ajaxtokengeneral').value,
        cliente_id: cliente_id,
        atencion:atencion,
        details: JSON.stringify(dataToSend)
    }
    let response = await appControl.fetchData(url_store_cotizacion, data , 'POST');
    if( response.type === undefined){
        for (const key in response.error) {
            if (response.error.hasOwnProperty(key)) {
                const messages = response.error[key];
                // Itera a través de los mensajes de error
                for (const message of messages) {
                    Swal.fire(`Campo: ${key}`, `Mensaje de error: ${message}`, 'warning');
                }
            }
        }
        return;
    }
    Swal.fire('', response.message, response.type);
    if( response.type != 'error' && response.type != undefined ){
        location.reload();
    }
}




