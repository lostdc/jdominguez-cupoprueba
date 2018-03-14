<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_tag');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_producto', 'id_tag']);

            $table ->foreign("id_producto")
                   ->references('id')
                   ->on('producto')
                   ->onDelete('restrict')
                   ->onUpdate('cascade');

            $table->foreign("id_tag")
                  ->references('id')
                  ->on('tag')
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
        Schema::table('producto_tag', function (Blueprint $table) {
            $table->dropForeign('producto_tag_id_producto_foreign');
            $table->dropForeign('producto_tag_id_tag_foreign');
            $table->dropIfExists('producto_tag');
        });
    }
}
