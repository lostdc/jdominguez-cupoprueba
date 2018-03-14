<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Producto,Tag,ProductoTag,Busqueda,ProductoBusqueda};


use Illuminate\Support\Facades\DB;
use Artisan;


class ProductoController extends Controller
{
    
    public function principal()
    {
        return view("productos.producto");
    }
    
    /**
     * listProductos
     *
     * @param Request $request
     * $request['lenght']: largo
     * $request['search']['value']: palabra buscada 
     * $request['start']: inicio de la busqueda limit
     * $request['page']: numero de la pagina buscada
     * $request['flagSearch']: indica si la busqueda fue realizada = 1 o solo es paginacion de lo ya buscado = 0
     * @return void
     */

     //este listado de productos tambien guarda estadisticas de resultadoss
    public function listProductos(Request $request)
    {
        
        $cantidadRegistros = $request["length"];
        $keyword          = trim($request["search"]["value"]);
        $flagSearch        = $request["flagSearch"];

        $limit = $request->input('length');
        
        $obProducto = new Producto();
        
        $columns = [
            "id",
            "titulo",
            "descripcion",
            "fecha_inicio",
            "fecha_termino",
            "precio",
            "imagen",
            "vendidos"
        ];

        //buscamos por titulos descripcion y tags

        $obProducto = $obProducto->select($columns);
        $obProducto->where(function($query) use ($keyword){

            $columns = ['titulo', 'descripcion'];
            foreach ($columns as $column ) {
                $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
            }

            $query->orWhereHas('tags', function($q) use ($keyword) {
                $q->where(function($q) use ($keyword) {
                    $q->where('nombre', 'LIKE', '%' . $keyword . '%');
                });
            });
        });


        $obProducto->with(["tags" => function($q){
            $columns = ["nombre"];
            $q->select("nombre");
        }]);

        //creamos la collecion con los datos
        $productoCollection = $obProducto->paginate($cantidadRegistros);


        //si es mayor a 0 guardamos los datos de buqueda y estaditicas

    
        if(count($productoCollection) > 0 && $keyword != "" && $flagSearch == 1):

            //inciciamos la transaccion
            DB::beginTransaction();

            $busqueda = new Busqueda();

            $busquedaCollection = $busqueda->select('id')->where('palabra',$keyword)->first();

           
            //guardamos la busqueda si esta no existe
            if(!$busquedaCollection):
                $busqueda->palabra = $keyword;

                
                if($busqueda->save()):
                    
                    //por cada producto encontrado registramos su busqueda en producto_busqueda
                    foreach ($productoCollection as $index => $producto):

                        $productoBusqueda = new ProductoBusqueda();
                        $productoBusqueda->id_producto = $producto->id;
                        $productoBusqueda->id_busqueda = $busqueda->id;
                        
                        if(!$productoBusqueda->save()):
                            //error
                            DB::rollBack();
                        endif;

                    endforeach;
                else:
                    //error
                    DB::rollBack();
                endif;
            else: //la busqueda existe la asignamos a los productos encontrados

                //por cada producto encontrado registramos su busqueda en producto_busqueda
                foreach ($productoCollection as $index => $producto):

                    $productoBusqueda = new ProductoBusqueda();

                    $columns = [
                        'id',
                        'cantidad'
                    ];

                    $conditions = [
                        'id_producto' => $producto->id,
                        'id_busqueda' => $busquedaCollection->id
                    ];


                    $productoBusquedaCollection = $productoBusqueda->select($columns)->where($conditions)->first();

                    

                    if($productoBusquedaCollection->count() == 0): //creamos el registro de busqueda
                        $productoBusqueda->id_producto = $producto->id;
                        $productoBusqueda->id_busqueda = $busquedaCollection->id;
                    
                        if(!$productoBusqueda->save()):
                            DB::rollBack();
                            //error
                        endif;
                    else://sumamos +1 a la cantidad ya existente

                        if(!$productoBusquedaCollection
                            ->update(
                                ["cantidad" => $productoBusquedaCollection->cantidad+1]
                            )):
                        //no se pudo actualizar
                        DB::rollBack();
                        endif;
                    endif;
                endforeach;
            endif;
        endif;

        //trasaccion finalizada registros de busquedas y producto_busqueda
        DB::commit();
        
    
        
        $arrayResponse          = [];
        $arrayResponse["data"]  = [];
        
        $arrayResponse["recordsTotal"]        = $productoCollection->total();
        $arrayResponse["recordsFiltered"]     = $productoCollection->total();
        
        foreach ($productoCollection as $indice => $producto):

            $arrayProdTags = $producto->tags->toArray();
            $arrayTags        = array_map(function($tag) { return $tag['nombre']; }, $arrayProdTags);
            $textTags = implode(",", $arrayTags);

            //Creamos una respuesta con la estructura utilizada por datatables
            array_push($arrayResponse["data"],
            [
                    $producto->titulo,
                    $producto->descripcion,
                    $producto->fecha_inicio->format('Y-m-d H:i:s'),
                    $producto->fecha_termino->format('Y-m-d H:i:s'),
                    $producto->precio,
                    "<img style='width:200px; heigth:150px; ' src='$producto->imagen' />",
                    $producto->vendidos,
                    $textTags
            ]);
        endforeach;

        return response()->json($arrayResponse);

        
    }


    //funcion elimina todos los productos, tags y producto_tag tables
    //tambien elimina estadisticas


    public function eliminar(){

        DB::table('producto_busqueda')->delete();
        DB::table('busqueda')->delete();
        DB::table('producto_tag')->delete();
        DB::table('producto')->delete();
        DB::table('tag')->delete(); 

    }

    //borra todos los datos de las tablas y ademas genera datos de prueba (solo en desarrollo)
    public function regenerar(){
               
        DB::table('producto_tag')->delete();
        DB::table('producto')->delete();
        DB::table('tag')->delete();
        
        Artisan::call('db:seed', ['--class' => 'ProductoSeeder','--force' => true]);
        Artisan::call('db:seed', ['--class' => 'TagSeeder','--force' => true]);
        Artisan::call('db:seed', ['--class' => 'ProductoTagSeeder','--force' => true]);
    }

    // funcion para cargar desde csv recibe un file
    public function cargarCSV()
    {
        //aumentamos el tiempo maximo de ejecucion predeterminado
        ini_set('max_execution_time', 360);

        $rutaCSV = $_FILES['archivo']['tmp_name'];

        if(empty($rutaCSV)):
			return "no hay ruta ingresada";
		endif;

        //inciciamos la transaccion
        DB::beginTransaction();
        
		if (($fichero = fopen($rutaCSV, "r")) !== FALSE):

            $indiceWhile = 0;
            //recorremos row a row los datos
            while (($datos = fgetcsv($fichero, 10000,",")) !== FALSE):
                
                //si estamos en la cabecera pasamos a la siguiente
                if($indiceWhile == 0):
                    $indiceWhile++;
                    continue; 
                endif;
                
                $producto = new Producto();
        
                foreach ($datos as $indice => $fila): 
                    
                    $fila = trim($fila);
                    


                    if($indice == 0):// campo de titulo
                        $producto->titulo = $fila;

                    elseif($indice == 1): //descripcion
                        $producto->descripcion = $fila;
                    elseif($indice == 2): //fecha_inicio
                        $producto->fecha_inicio  = $fila;
                    elseif($indice == 3): //fecha_termino
                        $producto->fecha_termino  = $fila;
                    elseif($indice == 4): //precio
                        $producto->precio  = $fila;
                    elseif($indice == 5): //imagen
                        $producto->imagen  = $fila;
                    elseif($indice == 6): //vendidos
                        $producto->vendidos  = $fila;
                    elseif($indice == 7): //tags

                        //si ingreso aqui ya tengo todos los datos de tabla producto
                        if($producto->save()):
                            // echo "se guardo sin erro";
                         else:
                            // echo "no se guardo";
                         endif;

                        $tags = explode(",",$fila);
                        
                        foreach($tags as $indexTag => $tag):
                            
                            $obTag = new Tag();    
                            $obTagCollection = $obTag->select('id')->where('nombre',$fila)->first();

                            //los nombres de tags son unicos tambien no se repiten
                            if(!$obTagCollection):
                                $obTag->nombre = $tag;

                                if($obTag->save()):
                                    $obProductoTag              = new ProductoTag();                                        
                                    $obProductoTag->id_producto = $producto->id;
                                    $obProductoTag->id_tag      = $obTag->id;
                                    $obProductoTag->save();

                                endif;
                            else:
                                //si existe el tag revisamos que ya este asociado al producto
                                $obProductoTag = new ProductoTag();
                                $conditions = [
                                    'id_producto' => $producto->id,
                                    'id_tag'      => $obTagCollection->id
                                ];

                                $obProductoTagCollection = $obProductoTag->select('id')->where($conditions)->first();

                                if(!$obProductoTagCollection): //si no esta asociado lo asociamos
                                    $obProductoTag->id_producto = $producto->id;
                                    $obProductoTag->id_tag      = $obTagCollection->id;
                                    $obProductoTag->save();
                                else:
                                    //ya existe no realizamos accion
                                endif;                                
                            endif;
                        endforeach;
                    endif;
                endforeach;      
                $indiceWhile++;
            endwhile;
        endif;
        DB::commit();
    }

    public function estadistica()
    {
        return view("estadisticas.estadistica");
    }

    public function listEstadistica()
    {
       
            $producto = new Producto();

            $columns = [
                "p.id",
                "p.titulo",
                "p.imagen",
                "pmaximos.total"
            ];

            //$producto = $producto->select($columns)  
            $productos = DB::table('producto as p')
                ->select($columns)
                ->join(DB::raw('(SELECT sum(cantidad) as total ,
                                id_producto  FROM producto_busqueda GROUP BY id_producto
                                order by sum(cantidad) desc limit 20
                                ) as pmaximos'
                ), function($join){
                   $join->on('p.id', '=', 'pmaximos.id_producto');
                })->get();
            //añadimos las 5 mayores busquedas
            
            $columns = [
                "id_producto",
                "b.palabra",
                "cantidad"
            ];

            $arrayResponse = [];
            $arrayResponse["data"] = [];



            


            foreach ($productos as $indice => $producto):  
                //encuentra las mayores busquedas de cada producto
                $busquedasMayores = DB::table('producto_busqueda as pb')
                    ->select($columns)
                    ->join(DB::raw('busqueda as b'
                    ), function($join) {
                        $join->on('b.id', '=', 'pb.id_busqueda');
                    })->where("pb.id_producto",$producto->id)
                    ->groupBy("id_producto","palabra")
                    ->orderBy("cantidad","desc")
                    ->limit(5)
                    ->get()->toArray();

                
                $busquedas          = array_column($busquedasMayores, 'palabra');
                $busquedasCantidad  = array_column($busquedasMayores, 'cantidad');

                $allBusquedas = [];

                $largo = count($busquedas);

                foreach ($busquedas as $indice => $busqueda):
                    array_push($allBusquedas,$busqueda."(".$busquedasCantidad[$indice].")"); 
                endforeach;

                $allBusquedas = implode(", ",$allBusquedas );
 
                $productos[$indice]->busquedas = $busquedas;


            
                array_push($arrayResponse["data"],
                [
                        $producto->id,
                        $producto->titulo,
                        $allBusquedas,
                        "<img style='width:250px; heigth:200px;' src='".$producto->imagen."' >"
                ]);



            endforeach;

            return response()->json($arrayResponse);


            //return   json_encode($arrayResponse);

    }
}
