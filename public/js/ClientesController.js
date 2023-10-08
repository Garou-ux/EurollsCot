appControl = appModule;
const url_store_cliente = document.getElementById('url_store_cliente').value;
const url_delete_cliente = document.getElementById('url_delete_cliente').value;
const openCreateModalButton = document.getElementById('openCreateModal');
const closeCreateModalButton = document.getElementById('closeCreateModal');
const createModal = document.getElementById('createModal');

openCreateModalButton.addEventListener('click', () => {
    createModal.classList.remove('hidden');
    limpiarFormulario();
    createModal.classList.add('animate-fade-in');
});

closeCreateModalButton.addEventListener('click', () => {
    createModal.classList.add('hidden');
    createModal.classList.remove('animate-fade-in');
    limpiarFormulario();
});
const createForm = document.getElementById('createForm');

const saveEditClient = async ( element ) => {
        const formData = new FormData(createForm);
        const clienteId = document.getElementById('clienteId').value;
        formData.append('clienteId', clienteId);
            try {
                const response = await fetch(url_store_cliente, {
                    method: 'POST',
                    body: formData,
                });
                if (response.ok) {
                    // Cerrar el modal y mostrar un mensaje de éxito
                    createModal.classList.add('hidden');
                    const data = await response.json();
                    Swal.fire('', data.message, data.type);
                    //  location.reload();
                } else {
                    // Mostrar un mensaje de error si la respuesta no es exitosa
                    const data = await response.json();
                    Swal.fire('Error', data.message || 'Ha ocurrido un error.', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha ocurrido un error.', 'error');
            }
    };

    const fileUpload = document.getElementById('file-upload');
    const imageName = document.getElementById('image-name');

    fileUpload.addEventListener('change', (e) => {
        // Verifica si se ha seleccionado un archivo
        if (e.target.files.length > 0) {
            // Obtiene el nombre del archivo seleccionado
            const fileName = e.target.files[0].name;
            // Muestra el nombre del archivo en el elemento #image-name
            imageName.textContent = `Imagen seleccionada: ${fileName}`;
        } else {
            // Si no se selecciona ningún archivo, borra el texto
            imageName.textContent = '';
        }
    });

    const confirmDeleteClient =  ( clienteId ) => {
        Swal.fire({
            icon: 'warning',
            title: '¿Estas seguro de eliminar el producto?',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                deleteClient(clienteId);
            }
          })
    };

    const deleteClient = async ( clienteId ) => {
        let data = {
            _token: document.getElementById('ajaxtokengeneral').value,
            clienteId : clienteId
        };
        let response = await appControl.fetchData(url_delete_cliente, data, 'POST');
        Swal.fire('', response.message, response.type);
        location.reload();
    };

    const openModalClients = ( element ) => {
        limpiarFormulario();
        let data = element.dataset;
        console.log(data);
        const fileUploadInput = document.getElementById('file-upload');
        const imageContainer = document.getElementById('image-name');

        // Verificar si hay una imagen disponible
        if (data.image_path) {
            // Ocultar el input de archivo
            fileUploadInput.style.display = 'none';

            // Crear un elemento de imagen y establecer su src
            const image = document.createElement('img');
            image.src = data.image_path;
            image.alt = 'Imagen de perfil';

            // Agregar la imagen al contenedor
            imageContainer.appendChild(image);
        } else {
            // Si no hay una imagen, puedes mostrar un mensaje
            imageContainer.textContent = 'No se ha cargado ninguna imagen.';
        }
        createModal.classList.remove('hidden');
        clienteId = document.getElementById('clienteId');
        clienteId.value = data.clienteid;
      // Obtener una referencia al formulario
        const form = document.getElementById('createForm');

        // Iterar sobre las propiedades del objeto
        for (const key in data) {
            if (Object.hasOwnProperty.call(data, key)) {
                const value = data[key];

                // Buscar el elemento de formulario con el mismo nombre que la propiedad del objeto
                const formElement = form.querySelector(`[name="${key}"]`);

                if (formElement) {
                    // Establecer el valor del elemento de formulario
                    formElement.value = value.trim(); // Trim para eliminar espacios en blanco al principio y al final
                }
            }
        }

        createModal.classList.add('animate-fade-in');
    }


    function limpiarFormulario() {
        const form = document.getElementById('createForm');
        form.reset(); // Esto restablecerá todos los campos del formulario
        // También puedes establecer valores específicos para campos como el nombre de archivo si es necesario
        // document.getElementById('image-name').textContent = '';
    }

    function mostrarImagen(clienteId, imagePath) {
        const fileUploadInput = document.getElementById('file-upload');
        const imageContainer = document.getElementById('image-name');

        // Verificar si hay una imagen disponible
        if (imagePath) {
            // Ocultar el input de archivo
            fileUploadInput.style.display = 'none';

            // Crear un elemento de imagen y establecer su src
            const image = document.createElement('img');
            image.src = imagePath;
            image.alt = 'Imagen de perfil';

            // Agregar la imagen al contenedor
            imageContainer.appendChild(image);
        } else {
            // Si no hay una imagen, puedes mostrar un mensaje
            imageContainer.textContent = 'No se ha cargado ninguna imagen.';
        }
    }



    document.addEventListener("DOMContentLoaded", ()=>{
        new DataTable('#tblProducts');
    })
