<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'cargaMasiva'], function() {
    route::get('nuevo','ProductoController@ingresarCargaMasiva');
});

Route::group(['prefix' => 'productos'], function() {

    route::get('','ProductoController@principal');
    route::delete('','ProductoController@eliminar');
    route::post('listProductos','ProductoController@listProductos');  
    route::get('regenerar','ProductoController@regenerar');
    route::post('cargarCSV','ProductoController@cargarCSV');
    route::get('estadistica','ProductoController@estadistica');

    route::post('estadistica/result','ProductoController@listEstadistica');
    route::get('estadistica/result','ProductoController@listEstadistica');



    
    
});