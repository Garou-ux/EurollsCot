// printJS({ printable: _url, type: 'pdf', showModal: true });

// function LoadGridProductos(CotizacionId){
//     $.ajax({
//       type: "GET",
//       // url: "http://localhost:8010/jsgridphp/countries/index.php"
//       data: {Caso : 0},
//       url: '../../controller/ctrlProducto.php?op=ListProductosGridCoti'
//   }).done(function(countries) {

//       countries.unshift({ ProductoId: "0", ProductoConcat: "" });
//       //GETDataClients();
//       $("#jsGridEditarCotizacion").jsGrid({

//           width: "100%",
//           filtering: false,
//           inserting: true,
//         editing: true,
//           sorting: true,
//           paging: true,
//           autoload: true,
//           deleteConfirm: "Estas seguro de eliminar el registo?",
//           controller: {
//             loadData: function(filter) {
//               return $.ajax({
//                   type: "POST",
//                   url: "../../controller/ctrlCotizacion.php?op=LoadCotizacionDetXId",
//                   data:{CotizacionId : CotizacionId }
//               }).done(function(data, response){
//                 var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//                 MontosRenglon(datagrid);
//                 });
//           },
//               insertItem: function(item) {
//                     if (item.Cantidad != undefined){
//                     item.CotizacionDetId = 0;
//                     item.CotizacionId = parseInt($('#CotizacionModId').val());
//                     var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//                     MontosRenglon(datagrid);
//                     }
//               },
//               updateItem: function(item) {
//                   // return $.ajax({
//                   //     type: "PUT",
//                   //     url: "http://localhost:8010/jsgridphp/clients/index.php",
//                   //     data: item
//                   // });
//               },
//               deleteItem: function(item) {
//                   // return $.ajax({
//                   //     type: "POST",
//                   //     url: "http://localhost:8010/jsgridphp/clients/index.php",
//                   //     data: item
//                   // });
//                   // var clientIndex = $.inArray(item, clientes);
//                   // clientes.splice(clientIndex, 1);
//                   var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//                   MontosRenglon(datagrid);
//               }
//           },

//           onItemUpdating: function(args) {
//             // cancel update of the item with empty 'name' field
//             if(args.item.Cantidad > 0) {
//                 //args.cancel = true;
//                 let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
//                 args.item.Total = CantidadGrid;
//                 var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//                 MontosRenglon(datagrid);
//             }
//         },
//     onItemInserting: function(args) {
//       if(args.item.Cantidad >0) {
//          let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
//          args.item.Total = CantidadGrid;
//           var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//           MontosRenglon(datagrid);
//       }
//   },
//   onItemUpdated: function(args) {
//     if(args.item.Cantidad > 0) {
//       let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
//       args.item.Total = CantidadGrid;
//       var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//       MontosRenglon(datagrid);
//     }
// },
// onItemEditing: function(args) {
//   if(args.item.Cantidad > 0) {
//    let CantidadGrid = args.item.Cantidad * parseFloat(args.item.Precio);
//                 args.item.Total = CantidadGrid;
//                 var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
//     MontosRenglon(datagrid);
//   }
// },
//     fields : [
//      {name : "CotizacionDetId", title: "CotizacionDetId", visible : false},
//      {name : "CotizacionId", title: "CotizacionId", visible : false},
//     { name : "ProductoId", title: "Producto", type: "select", width: 100, items: countries, /*valueField: "ProductoId",*/ textField: "ProductoConcat" ,
// //         insertTemplate: function(value, item) {
// //           console.log('in inserttemplate 0');
// //              var $select = jsGrid.fields.select.prototype.insertTemplate.call(this);
// //              $select.addClass('selectpicker form-control');
// //              $select.attr("data-live-search", "true");
// //  $select.attr("data-container", "body");

// //              setTimeout(function() {
// //                  $select.selectpicker({
// //                      liveSearch: true
// //                  });
// //                  $select.selectpicker('refresh');
// //                  $select.selectpicker('render');
// //              });
// //              console.log('in inserttemplate 2');
// //              return $select;
// //          },
//   // validate : { message: 'Ya seleccionaste ese producto', validator: function(value, item) {

//   // if(value <= 0){
//   // Mensaje = 'Favor de seleccionar un producto ;c';
//   // return false;
//   // }
//   //   var gridData = $("#jsGrid").jsGrid("option", "data");

//   //   for (i = 0; i < gridData.length; i++) {
//   //         if(value == gridData[i].ProductoId ){
//   //         Mensaje = 'Ya seleccionaste ese producto '
//   //           return false;

//   //         }
//   //     }
//   //   return true;

//   // } }
//   },
//   {
//       name : "Descripcion", title: "Descripcion", type : "text", filtering : false

//   },
//     { name : "Cantidad", title: "Cantidad", type: "number", width: 50, filtering: false,
//   validate : { message: "La cantidad debe ser mayor a 0", validator: function(value, item){ return value > 0;}},
//   },
//     { name : "Precio", title: "Precio", type: "text", width: 50, filtering: false ,
//   validate : { message: "El Precio debe ser mayor a 0", validator: function(value){ return parseFloat(value) > 0;}}
//   },
//     { name : "Total", title: "Total", width: 50, filtering: false, editable : false ,
// //validate : { message: "El Total debe ser mayor a 0", validator: function(value){ return value;}}
//   },
//     { type : "control"}
// ]
//   });

// });
// }
appControl = appModule;
const cotizacionData = document.getElementById('cotizacion_data').value;
const cotizacionDataJson = JSON.parse(cotizacionData);
const url_update_cotizacion = document.getElementById('url_update_cotizacion').value
const url_get_products = document.getElementById('url_get_products').value;
const url_get_clients = document.getElementById('url_get_clients').value;
const url_get_details = document.getElementById('url_get_details').value
const searchInput = document.createElement('input');
const selectPicker = document.getElementById('selectPicker');
const subtotalElement = document.getElementById('subtotal');
const ivaElement = document.getElementById('iva');
const totalElement = document.getElementById('total');
let productos = [];
console.log(cotizacionDataJson);

const getProducts = async  () => {
    let response = await appControl.fetchData(url_get_products, {}, 'GET');
    return response;
}

const getClients = async () => {
    let response = await appControl.fetchData(url_get_clients, {}, 'GET');
    return response;
}

const getDetails = async () => {
    let data = {
        _token: document.getElementById('ajaxtokengeneral').value,
        cotizacion_id : cotizacionDataJson.id
    }
    let response = await appControl.fetchData(url_get_details, data, 'POST');
    // console.log(response);
    return response;
}

function actualizarTotal(productos) {
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
    // console.log(productos);
    subtotalElement.textContent = '$' + subtotal.toFixed(2);
    ivaElement.textContent = '$' + iva.toFixed(2);
    totalElement.textContent = '$' + total.toFixed(2);
}


document.addEventListener('DOMContentLoaded', async function() {
    appControl.mostrarLoading();
    await loadGrid();
    // await getDetails();
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
    fillCotizacionFields(cotizacionDataJson);
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
    appControl.cerrarLoading();
});


const fillCotizacionFields = ( cotizacionDataJson ) => {
    let terminosElement = document.getElementById('terminos');
    let atencionElement = document.getElementById('atencion');
    let selectClientes  = document.getElementById("selectPicker");
    selectClientes.value = cotizacionDataJson.cliente_id;
    terminosElement.value = cotizacionDataJson.terminos;
    atencionElement.value = cotizacionDataJson.atencion;
};

function MontosRenglon(ObjectTotales){
    var Cantidad =0, Precio = 0, Total = 0;
//Recorremos todos los valores de la tabla para asi obtener los totales de los productos ya sumados
let SubTotal = 0, TotalCot = 0, IVA = 0, TotalCantidad =0, TotalPrecio = 0;
for (var i = 0; i < ObjectTotales.length; i++){
    TotalPrecio += parseFloat(ObjectTotales[i].Total);
}
SubTotal = TotalPrecio;
IVA = SubTotal * 0.16;
TotalCot = SubTotal + IVA;
// TotalCot = TotalPrecio;
// SubTotal = TotalCot / 1.16;
// IVA  = TotalCot * 0.16;
TotalCot = parseFloat(TotalCot).toFixed(2);
SubTotal = parseFloat(SubTotal).toFixed(2);
IVA  = parseFloat(IVA).toFixed(2);
// $('#SpanSubtotal').text(SubTotal);
// $('#SpanIVA').text(IVA);
// $('#SpanTotal').text(TotalCot);
    // }
    console.log(SubTotal, IVA, TotalCot);
    subtotalElement.textContent = '$' + SubTotal
    ivaElement.textContent = '$' + IVA;
    totalElement.textContent = '$' + TotalCot;
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
            loadData: async function(filter) {
                let data = await getDetails();
                // console.log('hola', data);
                // var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                data.forEach(item => {
                    productos.push({
                        cotizacion_id : item.cotizacion_id,
                        id:item.id,
                        producto_id: Number(item.producto_id),
                        cantidad: item.cantidad,
                        precio: parseFloat(item.precio),
                        importe: item.importe,
                        comentario: item.comentario
                    });
                })
                actualizarTotal(productos);
                return data;
            },
            insertItem: function(item){
                if(  item.cantidad  !== undefined ){
                    item.id = 0;
                    item.cotizacion_id = Number(cotizacionDataJson.id);
                    productos.push({
                        cotizacion_id : item.cotizacion_id,
                        id:0,
                        producto_id: Number(item.producto_id),
                        cantidad: item.cantidad,
                        precio: parseFloat(item.precio),
                        importe: item.importe,
                        comentario: item.comentario
                    });
                    actualizarTotal(productos);
                }

            },
            updateItem: function(item){},
            deleteItem: function(item){
                // var datagrid = $("#jsGridEditarCotizacion").jsGrid("option", "data");
                let productIndex = $.inArray(item, productos);
                productos.splice(productIndex, 1);
                console.log(item);
                actualizarTotal(productos);
            },
        },
            onItemUpdating: function(args){
                if(args.item.cantidad > 0){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log(args.item);
                    actualizarTotal(productos)
                    // MontosRenglon(productos);
                }
            },
            onItemInserting: function(args){
                if( args.item.cantidad > 0 ){
                    let cantidadGrid = args.item.cantidad *  parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log(args.item);
                    actualizarTotal(productos)
                }
            },
            onItemUpdated: function(args){
                if( args.item.cantidad > 0){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log(args.item);
                    actualizarTotal(productos)
                }
            },
            onItemEditing: function(args){
                if( args.item.cantidad > 0 ){
                    let cantidadGrid = args.item.cantidad * parseFloat(args.item.precio);
                    args.item.importe = cantidadGrid;
                    productos[args.itemIndex] = args.item;
                    console.log(args.item);
                    actualizarTotal(productos)
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
                        // console.log('in inserttemplate 0');
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
                    name: "comentario",
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
    // console.log(products);
};



const guardarBtn = document.getElementById('guardarBtn');
guardarBtn.addEventListener('click', guardarDatos);

async function guardarDatos() {
    const dataToSend = [];
    appControl.mostrarLoading();

    // Recorre cada fila de la tabla y recopila los datos
    productos.forEach((rowData) => {
        // console.log(rowData);
        const cotizacion_id = rowData.cotizacion_id
        const id = rowData.id
        const producto_id = rowData.producto_id;
        const cantidad = parseFloat(rowData.cantidad);
        const precio = parseFloat(rowData.precio);
        const importe = parseFloat(rowData.importe)
        const comentario = rowData.comentario
        dataToSend.push({ id, cotizacion_id, producto_id, cantidad, precio, importe, comentario });
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
        cotizacion_id: cotizacionDataJson.id,
        cliente_id: cliente_id,
        atencion:   atencion,
        terminos:   terminos,
        details:    JSON.stringify(dataToSend)
    }
    // console.log(data);
    // return;
    console.log(dataToSend);
    let response = await appControl.fetchData(url_update_cotizacion, data , 'POST');
    // console.log(response);
    if( response.type === undefined){
        appControl.cerrarLoading();
        for (const key in response.errors) {
            // console.log(response);
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
    // $.get('/generate-pdf', function (data) {
    //     mostrarPDF(data.pdf);
    // });
}


// Función para mostrar el PDF en SweetAlert2
function mostrarPDF(pdfBase64) {
    Swal.fire({
        title: 'PDF Generado',
        html: `<embed src="data:application/pdf;base64,${pdfBase64}" type="application/pdf" width="100%" height="600px" />`,
        showConfirmButton: false, // No muestra el botón de confirmación
    });
}
