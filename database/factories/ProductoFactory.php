<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Producto::class, function (Faker $faker) {
    return [
        "titulo"        => $faker->sentence($nbWords = 6, $variableNbWords = true) ,
        "descripcion"   => $faker->text ,
        "fecha_inicio"  => $faker->dateTime() ,
        "fecha_termino" => $faker->dateTime() ,
        "precio"        => $faker->randomNumber(6) ,
        "imagen"        => $faker->imageUrl($width = 200, $height = 150) ,
        "vendidos"      => $faker->randomNumber(3) 
    ];
});