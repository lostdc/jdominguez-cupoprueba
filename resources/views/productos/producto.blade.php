@extends('core.core')

@section('content')
<!-- Content Header (Page header) -->
<section>
    <h1>
        Listado de productos
    </h1>
</section>


<section>


    <button id="_btnEliminarTodo" class="btn btn-success">Borrar todos los productos y estadisticas </button>
    
   <!-- <button id="_btnRegenerar" class="btn btn-success"> Eliminar Todo el contenido y generar datos de prueba</button> -->
    <button id="_estadisticas" class="btn btn-success"> Ver las Estadísticas</button>

    <br /><br />
        <form id="formCSV"  method="post" enctype="multipart/form-data">
            <div class="form-group" >
                    <label class="btn btn-primary btn-file">
                        Cargar CSV <input type="file" name="archivo" id="archivo" required style="display: none;">
                    </label>
                    <button type="submit" class="btn btn-primary ">
                            Enviar CSV
                            <i id="iconoEnviar" style="font-size:15px;" class="fa fa-upload"></i>
                    </button> 
                
            </div>
        </form>
</section>

<section>

    <div class="row">
        <div class="col-md-4">
            <form class="form-inline"></form>
                <div class="form-group">
                    <label for="inputSearch">Busqueda</label>
                    <input type="text" class="form-control" id="inputSearch" />
                </div>
            </form>
        </div>
        <div class="col-md-4">
            
        </div>
        <div class="col-md-4">

        </div>
    </div>

    <input type="hidden" id ="numeroPagina" value="1"/>
    <input type="hidden" id ="flagSearch" value="0"/>
    
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">        
        <thead>
            <tr>
                <th>titulo</th>
                <th>descripcion</th>
                <th>fecha_inicio</th>
                <th>fecha_termino</th>
                <th>precio</th>
                <th>imagen</th>
                <th>vendidos</th>
                <th>tags</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>titulo</th>
                <th>descripcion</th>
                <th>fecha_inicio</th>
                <th>fecha_termino</th>
                <th>precio</th>
                <th>imagen</th>
                <th>vendidos</th>
                <th>tags</th>
            </tr>
        </tfoot>    
    </table>


</section>

@endsection

@section("endjs")

<script type="text/javascript" src="{{  URL::to(mix('/views/productos/producto.js')) }}"></script>


@endsection











