

var table;
$(document).ready(function() 
{
    //añadimos el token a todas las peticiones ajax
    /*
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });
    */ 
   
    //incicializamos la datatables con la lista de productos
    table = $('#example')
        .on('preXhr.dt', function ( e, settings, data ) {
            var info       = $('#example').DataTable().page.info();
            var flagSearch = $('#flagSearch').val();

            data.flagSearch = flagSearch;
            data.page = info.page+1
    }).DataTable({
        //español
        language: {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningun dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfo":           "",
            "sInfoEmpty":      "",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Ãšltimo",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            }
        },
    
        serverSide: true,
        processing: true,
        "bSort": false,
        responsive: true,
                  
        ajax: {
            "url"   : 'productos/listProductos',
            "data"  :{ function ( d ) {
                $("#example_filter").hide();
                //d.token = $("input[name='_token']").val();
                }
            },
            type: 'POST'
        },
        "drawCallback": function(settings) {
            var flagSearch = $('#flagSearch').val(0);
         }
    });//fin datatable

 
    $("#example_filter").hide();// ocultamos el buscador por defecto
    
    //realizamos las busquedas al presionar enter
    $('#inputSearch').on( 'keyup', function (e) {
        if(e.keyCode == 13) {
            var flagSearch = $('#flagSearch').val(1);
            table.search( this.value ).draw();
        }
    });
});//fin ready

//elimina todos los registros de la base de datos
$(document).on('click','#_btnEliminarTodo', function(){       
    $.ajax({
        url: 'productos',
        type: 'DELETE',
        table: table,
        success: function(result) {
            //alert("se eliminaron todos los productos")
            $('#example').DataTable().ajax.reload();
        }
    });

});

//elimina todos los registros y crea datos de prueba
$(document).on('click','#_btnRegenerar', function(){
    $.ajax({
        url: 'productos/regenerar',
        type: 'get',
        table: table,
        success: function(result) {
            alert("se incluyen nueva data de prueba")
            this.table.ajax.reload();
        }
    });
});


$("#formCSV").on("submit", function(e){
    
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
    })
    .done(function(res){
        $('#example').DataTable().ajax.reload();
            
    });
});

$(document).on("click","#_estadisticas", function(){

    window.location.href = "productos/estadistica";
});


