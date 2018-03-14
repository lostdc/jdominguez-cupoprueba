<?php

use Illuminate\Database\Seeder;
use App\Models\{Producto,Tag};

class ProductoTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * La funcion crea  
     * @return voi
     */
    public function run()
    {

        //La funcion crea 50 producto tags a partid de los productos y tags existentes
        $producto           = new Producto();
        $productoCollection = $producto->limit(50)->get();
        $tag                = new Tag();
        $tagCollection      = $tag->limit(50)->get();

        for($indice = 0; $indice < 50; $indice++):
            factory(App\Models\ProductoTag::class)->create([
                "id_producto"   => $productoCollection[$indice]->id ,
                "id_tag"        => $tagCollection[$indice]->id  
            ]);
        endfor;


    }
}
