

var appModule = ( function(){
    const messagesJson = () => {
      const MessagesEs = $('#messages_base').val();
      const ObjectMessages = JSON.parse(MessagesEs);
      return ObjectMessages;
    };
    const clearSelectPicker = (select) => {
      return $(`#${select}`).empty();
    };

    const clearForm = (form) => {
       return $(`#${form}`).trigger("reset");
    };

    const refreshSelectPicker = (select) => {
      return $(`.${select}`).selectpicker("refresh");
    };

    const liveSearchSelectPickers = () => {
      let select = $('.select');
          select.addClass('selectpicker form-control');
          select.attr("data-live-search", "true");
          select.attr("data-container", "body");

        return setTimeout(() => {
             select.selectpicker({
               livesearch : true
             });
             refreshSelectPicker('select');
             select.selectpicker("render");
          });
    };

      const serializeForm = (form) => {
        var parsedData = {_token :  $("#ajaxtokengeneral").val()};
        $(`#${form}`).serializeArray().map(function(x){parsedData[x.name] = x.value;});
        return parsedData;
    };

    const saveForm = async (data) => {
       const response = await fetchData(data.url,data, 'POST'); //generalomolap.js
       return response;
   };

   const disableInput = (input) => {
     return document.getElementById(`${input}`).disabled = true;
   };

   const offDisableInput = (input) => {
    return document.getElementById(`${input}`).disabled = false;
   };

    const fillSelectPicker = (objectSelect) => {
        let select = $(`#${objectSelect.select}`);
        clearSelectPicker(objectSelect.select);
        refreshSelectPicker(objectSelect.class);
        let option = `<option/>`;
        for (const process of objectSelect.data) {
          select.append($(option).val(`${process.value}`).text(process.text));
        }
        refreshSelectPicker('select');
    };

    const hideElement = (elementId) => {
        let element = document.getElementById(elementId);
        return element.style.display = "hide";
    };

    const showElement = (elementId) => {
       let element = document.getElementById(elementId);
       return element.style.display = "block";
    };

    const openModal = (modal) => {
       return $(`#${modal}`).modal("show");
    };

    const hideModal = (modal) => {
       return $(`#${modal}`).modal("hide");
    };

   const focusInput = (input) => {
     return $(`#${input}`).focus();
   };

   const fetchDataWithFiles = async (url,data) =>{
        const response = await fetch(url,{
            method: 'POST',
            headers:{
                "X-CSRF-Token": $('#ajaxtokengeneral').val(),
                "X-Requested-With": "XMLHttpRequest",
            },
            body:data
        })
        return response.json();
   };

   const setValueToInput = (input, value) => {
      document.getElementById(`${input}`).value = `${value}`;
   };

   const getInputValue = (input) => {
       return document.getElementById(`${input}`).value;
   };

   const hideElementByClass = (_class) => {
       let element = document.getElementsByClassName(_class);
       return element.style.display = "hide";
   };

   const showElementByClass = (_class) => {
       let element = document.getElementsByClassName(_class);
       return element.style.display = "block";
   };

    /*
      espera elemento this en la funcion onscroll
      _function = funcion asincrona en la cual estaremos paginando en base al scroll, se retornara un json y se crea el template que tu le asignes
      data_page =  los datos de la pagina para setearlos en base al scroll
    */
   const infiniteScrollDiv = async (div, _function, data_page, scroll_id = '') => {
       let height = $(div).height();
       let currentScrollPosition =  $(div).scrollTop() + $(div).height();
       if( currentScrollPosition > data_page.previousScrollPosition ){
           if( currentScrollPosition >= height && data_page.bool == false && data_page.lastPage > data_page.pages -2 ){
               data_page.bool = true;
               $('.ajax-load').show();
               await _function(scroll_id, data_page.pages);
               data_page.bool = false;
               data_page.pages++
               if(data_page.pages - 2 == data_page.lastPage){
                $('.no-data').show();
               }

           }
       }
       data_page.previousScrollPosition = currentScrollPosition;
       return data_page;
   };

   const clearSelect = (select) => {
    return $(`#${select}`).empty();
  };

   const fillSelect = (objectSelect) => {
       let select = $(`#${objectSelect.select}`);
       clearSelectPicker(objectSelect.select);
       let option = `<option/>`;
       for (const process of objectSelect.data) {
           if(process.value === Number(objectSelect.selected)){
               option = '<option selected/>';
           }else{
               option = '<option/>';
           }
           select.append($(option).val(`${process.value}`).text(process.text));
       }
   };

   const loadBasicTableArrayObject = ( options ) => {
       table =  $(`#${options.tableId}`).DataTable({
                    data: options.dataSet,
                    "destroy": true,
                    columns: options.columns,
                    rowCallback: options.rowCallbackFn
                });

       return table;
   }

   const requestMethods = () => ({
       post : 'POST',
       get  : 'GET'
   });

   const printErrorMsg = (msg) => {
       $(".alert-request").html('');
       $(".alert-request").css('display','block');
       $.each( msg, function( key, value ) {
           $("[for="+key+"]").append(`<small class='alert-request text-danger'>${value}<small>`);
       });
   }

   const clearErrorMsg = () => {
       $(".alert-request").html('');
       $(".alert-request").css('display','none');
   }

   const noDataTemplate = () => {
    let html = `
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <center><h5>No Data Found.</h5></center>
                </div>
                <div class="card-block">
                    <p>
                    </p>
                </div>
            </div>
        </div>
    `;
    return html;
};

const initDatePickers = (preset, id) =>{
   return new dateDropper({
        selector: `#${id}`,
        preset: `${preset}`,
        dropWidth: 200,
        init_animation: "bounce",
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c"

   });
};

const templatesModal =  {
    buttonClose : () => {
        return `
            <button type="button" class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        `
    }
}

const filterYearTemplate = ( id ) => {
    return `
    <div class="col-sm-2">
        <small> Year </small>
        <input id="${id}" class="form-control" type="text" data-dd-opt-preset="onlyYear" required>
    </div>
    `;
};

const filterMonthTemplate = ( id ) => {
    return `
    <div class="col-sm-2">
        <small> Month </small>
        <input id="${id}" class="form-control" type="text" data-dd-opt-preset="onlyMonth" required>
    </div>
    `;
};

const swal1Loading = () => {
    swal({
        title: 'Loading',
        text: '',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
      });
      swal.showLoading();
}

const initCloseModalTailwin = () => {
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggles = document.querySelectorAll('[data-dropdown-toggle]');
    console.log(dropdownToggles);
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const dropdownId = this.getAttribute('data-dropdown-toggle');
                const dropdown = document.getElementById(dropdownId);
                console.log(dropdownId);
                console.log(dropdown);
                dropdown.classList.toggle('hidden');
            });
        });
    });
};

        const fetchData = async(url = "", data = {}, method = 'GET') => {
            const response = await fetch(url, {
            method: method,
            mode: "same-origin",
                cache: "no-cache",
                credentials: "same-origin",
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": data._token
                },
                redirect: "follow",
                referrerPolicy: "no-referrer",
                body : method === "GET" ? null : JSON.stringify(data)

            });

        return response.json();
        }

    return {
        messagesJson,
        clearSelectPicker,
        clearForm,
        refreshSelectPicker,
        liveSearchSelectPickers,
        serializeForm,
        saveForm,
        disableInput,
        offDisableInput,
        fillSelectPicker,
        hideElement,
        showElement,
        openModal,
        hideModal,
        focusInput,
        fetchDataWithFiles,
        setValueToInput,
        getInputValue,
        hideElementByClass,
        showElementByClass,
        infiniteScrollDiv,
        fillSelect,
        loadBasicTableArrayObject,
        requestMethods,
        printErrorMsg,
        clearErrorMsg,
        noDataTemplate,
        initDatePickers,
        templatesModal,
        filterYearTemplate,
        filterMonthTemplate,
        swal1Loading,
        initCloseModalTailwin,
        fetchData
     };
})();
