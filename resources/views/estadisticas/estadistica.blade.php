@extends('core.core')
@section('content')
<!-- Content Header (Page header) -->
<section>
    <h1>
        Estadisticas de productos
    </h1>
</section>

<section>    
    <input type="hidden" id ="numeroPagina" value="1"/>
    <input type="hidden" id ="flagSearch" value="0"/>
    
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">        
        <thead>
            <tr>
                <th>id</th>
                <th>titulo</th>
                <th>Busquedas</th>
                <th>imagen</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>id</th>
                <th>titulo</th>
                <th>Busquedas</th>
                <th>imagen</th>
            </tr>
        </tfoot>    
    </table>
</section>

@endsection

@section("endjs")
    <script type="text/javascript" src="{{  URL::to(mix('/views/estadisticas/estadistica.js')) }}"></script>
@endsection
