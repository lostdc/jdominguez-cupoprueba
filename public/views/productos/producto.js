/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/views/productos/producto.js":
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var table;
$(document).ready(function () {
    var _language;

    //añadimos el token a todas las peticiones ajax
    /*
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });
    */

    //incicializamos la datatables con la lista de productos
    table = $('#example').on('preXhr.dt', function (e, settings, data) {
        var info = $('#example').DataTable().page.info();
        var flagSearch = $('#flagSearch').val();

        data.flagSearch = flagSearch;
        data.page = info.page + 1;
    }).DataTable({
        //español
        language: (_language = {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros"
        }, _defineProperty(_language, 'sInfo', ""), _defineProperty(_language, 'sInfoEmpty', ""), _defineProperty(_language, "sInfoFiltered", "(filtrado de un total de _MAX_ registros)"), _defineProperty(_language, "sInfoPostFix", ""), _defineProperty(_language, "sSearch", "Buscar:"), _defineProperty(_language, "sUrl", ""), _defineProperty(_language, "sInfoThousands", ","), _defineProperty(_language, "sLoadingRecords", "Cargando..."), _defineProperty(_language, "oPaginate", {
            "sFirst": "Primero",
            "sLast": "Ãšltimo",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        }), _language),

        serverSide: true,
        processing: true,
        "bSort": false,
        responsive: true,

        ajax: {
            "url": 'productos/listProductos',
            "data": {
                function: function _function(d) {
                    $("#example_filter").hide();
                    //d.token = $("input[name='_token']").val();
                }
            },
            type: 'POST'
        },
        "drawCallback": function drawCallback(settings) {
            var flagSearch = $('#flagSearch').val(0);
        }
    }); //fin datatable


    $("#example_filter").hide(); // ocultamos el buscador por defecto

    //realizamos las busquedas al presionar enter
    $('#inputSearch').on('keyup', function (e) {
        if (e.keyCode == 13) {
            var flagSearch = $('#flagSearch').val(1);
            table.search(this.value).draw();
        }
    });
}); //fin ready

//elimina todos los registros de la base de datos
$(document).on('click', '#_btnEliminarTodo', function () {
    $.ajax({
        url: 'productos',
        type: 'DELETE',
        table: table,
        success: function success(result) {
            //alert("se eliminaron todos los productos")
            $('#example').DataTable().ajax.reload();
        }
    });
});

//elimina todos los registros y crea datos de prueba
$(document).on('click', '#_btnRegenerar', function () {
    $.ajax({
        url: 'productos/regenerar',
        type: 'get',
        table: table,
        success: function success(result) {
            alert("se incluyen nueva data de prueba");
            this.table.ajax.reload();
        }
    });
});

$("#formCSV").on("submit", function (e) {

    e.preventDefault();
    var f = $(this);

    var formData = new FormData(document.getElementById("formCSV"));

    //$("#iconoEnviar").removeClass("fa-upload");
    //$("#iconoEnviar").addClass("fa-spinner fa-pulse fa-3x fa-fw");

    $.ajax({
        url: "productos/cargarCSV",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (res) {
        $('#example').DataTable().ajax.reload();
        /*
        $("#iconoEnviar").removeClass("fa-spinner fa-pulse fa-3x fa-fw");
        $("#iconoEnviar").addClass("fa-upload");
        $("#mensaje").html("Respuesta: " + res);
        */

        //alert("csv cargado correctamente");
    });
});

$(document).on("click", "#_estadisticas", function () {

    window.location.href = "productos/estadistica";
});

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/views/productos/producto.js");


/***/ })

/******/ });