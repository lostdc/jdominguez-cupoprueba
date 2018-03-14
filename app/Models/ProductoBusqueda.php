<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Mar 2018 00:44:46 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductoBusqueda
 * 
 * @property int $id
 * @property int $id_producto
 * @property int $id_busqueda
 * @property int $cantidad
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Busqueda $busqueda
 * @property \App\Models\Producto $producto
 *
 * @package App\Models
 */
class ProductoBusqueda extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'producto_busqueda';

	protected $casts = [
		'id_producto' => 'int',
		'id_busqueda' => 'int',
		'cantidad' => 'int'
	];

	protected $fillable = [
		'id_producto',
		'id_busqueda',
		'cantidad'
	];

	public function busqueda()
	{
		return $this->belongsTo(\App\Models\Busqueda::class, 'id_busqueda');
	}

	public function producto()
	{
		return $this->belongsTo(\App\Models\Producto::class, 'id_producto');
	}
}
