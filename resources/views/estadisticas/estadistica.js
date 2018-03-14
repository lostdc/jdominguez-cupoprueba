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

    //incicializamos la datatables con la estadistica
    table = $('#example').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "search": false,
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
        "processing": true,
        "serverSide": true,

        "ajax": {
            "url": "estadistica/result",
            "data"  :{ function ( d ) {
                $("#example_filter").hide();
                //d.token = $("input[name='_token']").val();
                }
            },
            "type": "POST"
        }
    });
});