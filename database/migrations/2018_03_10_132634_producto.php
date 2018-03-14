<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Producto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string("titulo");
            $table->text("descripcion");
            $table->dateTime("fecha_inicio");
            $table->dateTime("fecha_termino");
            $table->unsignedInteger("precio");
            $table->string("imagen");
            $table->unsignedInteger("vendidos")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
