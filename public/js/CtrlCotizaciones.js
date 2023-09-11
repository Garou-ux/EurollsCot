
appControl = appModule;

const url_store_cotizacion = document.getElementById('url_store_cotizacion').value;
const url_get_products = document.getElementById('url_get_products').value;
const url_get_clients = document.getElementById('url_get_clients').value;
const searchInput = document.createElement('input');
const selectPicker = document.getElementById('selectPicker');
const subtotalElement = document.getElementById('subtotal');
const ivaElement = document.getElementById('iva');
const totalElement = document.getElementById('total');
let productos = [];

const getProducts = async  () => {
    let response = await appControl.fetchData(url_get_products, {}, 'GET');
    return response;
}

const getClients = async () => {
    let response = await appControl.fetchData(url_get_clients, {}, 'GET');
    return response;
}




const loadGrid = async () => {
    let products = await getProducts();
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
            insertItem: function(item){
                if(  item.cantidad  !== undefined ){
                    productos.push({
                        cotizacion_id : 0,
                        id:0,
                        producto_id: Number(item.producto_id),
                        cantidad: item.cantidad,
                        precio: parseFloat(item.precio),
                        importe: item.importe,
                        comentario: item.comentarios
                    });
                    actualizarTotal(productos);
                }

            },
            updateItem: function(item){},
            deleteItem: function(item){
                let productIndex = $.inArray(item, productos);
                productos.splice(productIndex, 1);
                actualizarTotal(productos);
            },
        },
            onItemUpdating: function(args){
                if(args.item.cantidad > 0){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    actualizarTotal(productos);
                }
            },
            onItemInserting: function(args){
                if( args.item.cantidad > 0 ){
                    let cantidadGrid = args.item.cantidad *  parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    actualizarTotal(productos);
                }
            },
            onItemUpdated: function(args){
                if( args.item.cantidad > 0){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    actualizarTotal(productos);
                }
            },
            onItemEditing: function(args){
                if( args.item.cantidad > 0 ){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
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
                    filtering: false
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


document.addEventListener('DOMContentLoaded', async function() {
    await loadGrid();
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
});



const guardarBtn = document.getElementById('guardarBtn');
guardarBtn.addEventListener('click', guardarDatos);

async function guardarDatos() {
    const dataToSend = [];
    appControl.mostrarLoading();

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
        details:    JSON.stringify(dataToSend)
    }
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
    if( response.type != 'error' && response.type != undefined ){
        // location.reload();
    }
        // Hacer una solicitud AJAX para generar el PDF y mostrarlo
    $.get('/generate-pdf', function (data) {
        mostrarPDF(data.pdf);
    });
}


// Función para mostrar el PDF en SweetAlert2
function mostrarPDF(pdfBase64) {
    Swal.fire({
        title: 'PDF Generado',
        html: `<embed src="data:application/pdf;base64,${pdfBase64}" type="application/pdf" width="100%" height="600px" />`,
        showConfirmButton: false, // No muestra el botón de confirmación
    });
}


