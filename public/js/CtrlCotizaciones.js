
appControl = appModule;

const url_store_cotizacion = document.getElementById('url_store_cotizacion').value;
const url_get_products = document.getElementById('url_get_products').value;
const url_get_clients = document.getElementById('url_get_clients').value;
const url_get_pdf = document.getElementById('url_get_pdf').value;
const url_get_client_email = document.getElementById('url_get_client_email').value;
const searchInput = document.createElement('input');
const selectPicker = document.getElementById('selectPicker');
const subtotalElement = document.getElementById('subtotal');
const ivaElement = document.getElementById('iva');
const totalElement = document.getElementById('total');
let changeClient = false;
let productos = [];

const getProducts = async  () => {
    let response = await appControl.fetchData(url_get_products, {}, 'GET');
    return response;
}

const getClients = async () => {
    let response = await appControl.fetchData(url_get_clients, {}, 'GET');
    return response;
}


const getpdf = async(cotizacion_id) => {
    let data = {
        _token : document.getElementById('ajaxtokengeneral').value,
        cotizacion_id: cotizacion_id
    };
    let response = await appControl.fetchData(url_get_pdf, data, 'POST');

 printJS({ printable: response.html, type: "raw-html", showModal: true })
}

const getClientesEmails = async( cliente_id ) => {
    let data = { _token: document.getElementById('ajaxtokengeneral').value, cliente_id: cliente_id   };
    let response = await appControl.fetchData(url_get_client_email, data, 'POST');
    return response;
};

const loadGrid = async () => {
    let products = await getProducts();
    console.log('primero');
    console.log(products);
    // products.unshift({ id: "0", clave: "" });
    $("#jsGridReporteServicio").jsGrid({
        width: "100%",
        filtering: false,
        inserting: true,
        editing:   true,
        sorting:   true,
        paging:    true,
        autoload:  true,
        deleteConfirm: "¿Estas seguro de eliminar la fila ?",
        controller:{
            loadData: function(filter) {
            },
            // insertItem: function(item){
            //     if(  item.cantidad  !== undefined ){
            //         productos.push({
            //             cotizacion_id : 0,
            //             id:0,
            //             producto_id: Number(item.producto_id),
            //             cantidad: item.cantidad,
            //             precio: parseFloat(item.precio),
            //             importe: item.importe,
            //             comentario: item.comentarios
            //         });
            //         actualizarTotal(productos);
            //     }

            // },
            updateItem: function(item){
                console.log('updateItem');
                console.log(item);
                console.log(productos);
                let cantidadGrid = item.cantidad * parseFloat(item.precio);
                item.importe = cantidadGrid;
                productos[args.itemIndex] = args.item;
                actualizarTotal(productos);
            },
            deleteItem: function(item){
                let productIndex = $.inArray(item, productos);
                productos.splice(productIndex, 1);
                console.log('deleteItem');
                console.log(item);
                console.log(productos);
                actualizarTotal(productos);
            },
        },
            onItemUpdating: function(args){
                if(args.item.cantidad > 0){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log('onItemUpdating');
                    console.log(args);
                    console.log(productos);
                    actualizarTotal(productos);
                }
            },
            onItemInserting: function(args){
                if( args.item.cantidad > 0 ){
                    let cantidadGrid = args.item.cantidad *  parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    // productos[args.itemIndex] = args.item;
                    console.log('onItemInserting');
                    console.log(args);
                    productos.push({
                        cotizacion_id : 0,
                        id:0,
                        producto_id: Number( args.item.producto_id),
                        cantidad:  args.item.cantidad,
                        precio: parseFloat( args.item.precio),
                        importe:  args.item.importe,
                        comentario:  args.item.comentarios
                    });
                    console.log(productos);
                    actualizarTotal(productos);
                }
            },
            onItemUpdated: function(args){
                if( args.item.cantidad > 0){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log('onItemUpdated');
                    console.log(args);
                    console.log(productos);
                    actualizarTotal(productos);
                }
            },
            onItemEditing: function(args){
                if( args.item.cantidad > 0 ){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log('onItemEditing');
                    console.log(args);
                    console.log(productos);
                    actualizarTotal(productos);
                }
            },
            fields: [
                {
                    name:    "cotizacion_id",
                    title:   "cotizacion_id",
                    visible: false
                },
                {
                    name:   "id",
                    title:  "id",
                    visible: false
                },
                {
                    name: "producto_id",
                    title: "Material",
                    type: "select",
                    width: 100,
                    items: products,
                    valueField: "producto_id",
                    textField: "clave",
                    insertTemplate: function(value, item) {
                        console.log('in inserttemplate 0');
                        var $select = jsGrid.fields.select.prototype.insertTemplate.call(this);
                        $select.addClass('select2','h-6', 'px-3', 'rounded');
                        setTimeout(() => {
                            $select.select2({
                                search: true
                            });
                            const elementos = document.querySelectorAll('.select2-container');
                            elementos.forEach(elemento => {
                                elemento.style.width = 'inherit';
                            })
                        },);
                        return $select;
                   },
                },
                {
                    name: "comentarios",
                    title: "Comentario",
                    type: "text",
                    filtering: false,
                    validate: { validator: "rangeLength", param: [0, 80],  message: "El comentario sobrepasa la cantidad de caracteres permitidos" }
                },
                {
                    name: "cantidad",
                    title: "Cantidad",
                    type: "number",
                    width: 50,
                    filtering: false,
                    validate: {
                        message: "La cantidad debe ser mayor a 0",
                        validator: function(value, item){
                            return value > 0;
                        }
                    }
                },
                {
                    name: "precio",
                    title: "Precio",
                    type: "text",
                    width: 50,
                    filtering: false,
                    validate: {
                        messsage: "El precio debe ser mayor a  0",
                        validator: function( value, item){
                            return parseFloat(value) > 0;
                        }
                    }
                },
                {
                    name: "importe",
                    title: "Total",
                    width: 50,
                    filtering: false,
                    editable: false
                },
                {
                    type: "control"
                }
            ]
    });
    console.log(products);
};


function actualizarTotal() {
    let subtotal = 0;

    productos.forEach((rowData) => {
        const producto = rowData.producto_id;
        const cantidad = parseFloat(rowData.cantidad);
        const precio = parseFloat(rowData.precio);
        const total = cantidad * precio;

        // rowData.total.textContent = '$' + total.toFixed(2);

        subtotal += total;
    });

    const iva = subtotal * 0.16;
    const total = subtotal + iva;
    console.log(productos);
    subtotalElement.textContent = '$' + subtotal.toFixed(2);
    ivaElement.textContent = '$' + iva.toFixed(2);
    totalElement.textContent = '$' + total.toFixed(2);
}

function searchClient(emailsData) {
    const searchEmailInput = document.getElementById('nuevo_input');
    const searchTerm = searchEmailInput.value.toLowerCase();
    const filteredOptions = emailsData.filter(option =>
      option.correo.toLowerCase().includes(searchTerm)
    );
    const selectPicker = document.getElementById('nuevo_select');

    // Limpia las opciones anteriores
    while (selectPicker.options.length > 0) {
      selectPicker.options[0].remove();
    }

    // Agrega las opciones filtradas
    filteredOptions.forEach(option => {
      const newOption = new Option(option.correo, option.id);
      newOption.dataset.id = option.id;
      newOption.dataset.cliente_id = option.cliente_id;
      newOption.dataset.correo = option.correo;
      // Agrega otros atributos data-* según tus necesidades
      selectPicker.add(newOption);
    });
  }

  // Función para verificar si una cadena es un correo electrónico válido
function isValidEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailRegex.test(email);
}


document.addEventListener('DOMContentLoaded', async function() {
    await loadGrid();
    const options = await getClients();
    console.log(options);
    let nuevoInput; // Declaración de la variable fuera del bloque condicional
    let label;
    let nuevoSelect;
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

    selectPicker.addEventListener('change', async function () {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption) {
            changeClient = true;
            // Actualiza el contenido de los elementos <p> con los valores del dataset
            direccionCli.textContent = selectedOption.dataset.direccion || '';
            emailCli.textContent = selectedOption.dataset.correo || '';
            codigoPostal.textContent = selectedOption.dataset.codigoPostal || '';
            console.log(selectedOption);
            let cliId = selectedOption.dataset.id;
            let emails = await getClientesEmails(cliId);
            console.log(emails);
            if (nuevoInput) {
                nuevoInput.remove();
              }
              if (label) {
                label.remove();
              }
              if (nuevoSelect) {
                nuevoSelect.remove();
              }

              // Crea un nuevo elemento input
              nuevoInput = document.createElement("input");
              nuevoInput.type = "text";
              nuevoInput.name = "nuevo_input";
              nuevoInput.id = "nuevo_input";
              nuevoInput.placeholder = "Correo de cliente";

              // Crea un nuevo label para el input
              label = document.createElement("label");
              label.className = "text-xs text-gray-500";

              // Crea un nuevo elemento select
              nuevoSelect = document.createElement("select");
              nuevoSelect.id = "nuevo_select";
            emails.forEach(option => {
                const newOption = new Option(option.correo, option.id);
                newOption.dataset.id = option.id;
                newOption.dataset.cliente_id = option.cliente_id;
                newOption.dataset.correo = option.correo;
                // Agrega otros atributos data-* según tus necesidades
                nuevoSelect.add(newOption);
            });

              codigoPostal.insertAdjacentElement("afterend", nuevoInput);
              nuevoInput.insertAdjacentElement("afterend", nuevoSelect);
              nuevoInput.addEventListener('input', () => {
                searchClient(emails);
              });


        }
    });

    var changeEvent = new Event("change", {
        bubbles: true, // Permite que el evento burbujee
        cancelable: true, // Permite que el evento sea cancelable
      });

    setTimeout(() => {
        var selectElement = document.getElementById("selectPicker");
        selectElement.dispatchEvent(changeEvent);
        console.log('aaa')
    }, 1000);
});



const guardarBtn = document.getElementById('guardarBtn');
guardarBtn.addEventListener('click', guardarDatos);

async function guardarDatos() {
    const dataToSend = [];
    appControl.mostrarLoading();
     if(!changeClient){
        appControl.cerrarLoading();
        Swal.fire('', 'Selecciona un cliente', 'warning');
     }
    // Recorre cada fila de la tabla y recopila los datos
    productos.forEach((rowData) => {
        const producto_id = rowData.producto_id;
        const cantidad = parseFloat(rowData.cantidad);
        const precio = parseFloat(rowData.precio);
        const importe = parseFloat(rowData.importe)
        const comentario = rowData.comentario
        dataToSend.push({ producto_id, cantidad, precio, importe, comentario });
    });

    let cliente_id = document.getElementById('selectPicker').value;
    let terminos = document.getElementById('terminos').value;
    let atencion = document.getElementById('atencion').value;
    const nuevoInput = document.getElementById('nuevo_input');
    const nuevoSelect = document.getElementById('nuevo_select');

    let valorAGuardar = ''; let is_input = false;

    // Verifica si el valor del input es un correo electrónico válido
    if (isValidEmail(nuevoInput.value)) {
        const result = await Swal.fire({
          title: '¿Desea guardar el correo del cliente?',
          text: nuevoInput.value,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Guardar',
          cancelButtonText: 'Cancelar',
        });

        if (result.isConfirmed) {
          valorAGuardar = nuevoInput.value;
          // Realiza el proceso de guardado aquí
          console.log('Correo a guardar:', valorAGuardar);
          is_input = true;
        }
      } else {
        if (nuevoSelect.options.selectedIndex !== -1) {
          valorAGuardar = nuevoSelect.options[nuevoSelect.selectedIndex].text;
          console.log('Valor a guardar:', valorAGuardar);
        }
      }


    // Realiza el proceso de guardado aquí, por ejemplo, puedes imprimir el valor en la consola
    console.log('Valor a guardar:', valorAGuardar);
    console.log(is_input);

    // Limpia el input después de guardar (opcional)
    nuevoInput.value = '';


    // Restaura el select a su valor predeterminado (opcional)
    // nuevoSelect.selectedIndex = 0;
    //  return;
    if(atencion === '' || atencion === undefined){
        appControl.cerrarLoading();
        Swal.fire('', 'El campo de atencion no puede estar vacio', 'warning');
        return;
    }

    if ( dataToSend.length <= 0 ){
        appControl.cerrarLoading();
        Swal.fire('', 'Debes de capturar al menos un producto', 'warning');
        return;
    }


    let data = {
        _token: document.getElementById('ajaxtokengeneral').value,
        cliente_id: cliente_id,
        atencion:   atencion,
        terminos:   terminos,
        is_input: is_input,
        correo: valorAGuardar,
        details:    JSON.stringify(dataToSend)
    }
    console.log(data);
    // return;
    let response = await appControl.fetchData(url_store_cotizacion, data , 'POST');
    console.log(response);
    if( response.type === undefined){
        appControl.cerrarLoading();
        for (const key in response.errors) {
            console.log(response);
            if (response.errors.hasOwnProperty(key)) {
                const messages = response.errors[key];
                // Itera a través de los mensajes de error
                for (const message of messages) {
                    Swal.fire(`Campo: ${key}`, `Mensaje de error: ${message}`, 'warning');
                }
            }
        }
        return;
    }
    appControl.cerrarLoading();
    Swal.fire('', response.message, response.type);
    // if( response.type != 'error' && response.type != undefined ){
    //     location.reload();
    // }
        // Hacer una solicitud AJAX para generar el PDF y mostrarlo
        getpdf(response.cotizacion_id);
}


// Función para mostrar el PDF en SweetAlert2
function mostrarPDF(pdfBase64) {
    Swal.fire({
        title: 'PDF Generado',
        html: `<embed src="data:application/pdf;base64,${pdfBase64}" type="application/pdf" width="100%" height="600px" />`,
        showConfirmButton: false, // No muestra el botón de confirmación
    });
}


