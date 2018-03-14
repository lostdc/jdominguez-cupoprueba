<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoBusqueda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_busqueda', function (Blueprint $table) {
            

            $table->increments('id');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_busqueda');
            $table->unsignedInteger('cantidad')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_producto', 'id_busqueda']);

            $table ->foreign("id_producto")
                   ->references('id')
                   ->on('producto')
                   ->onDelete('restrict')
                   ->onUpdate('cascade');

            $table->foreign("id_busqueda")
                  ->references('id')
                  ->on('busqueda')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('producto_busqueda', function (Blueprint $table) {
            $table->dropForeign('producto_busqueda_id_producto_foreign');
            $table->dropForeign('producto_busqueda_id_busqueda_foreign');
            $table->dropIfExists('producto_busqueda');
        });
    }
}
