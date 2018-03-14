<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 10 Mar 2018 19:21:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Producto
 * 
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property \Carbon\Carbon $fecha_inicio
 * @property \Carbon\Carbon $fecha_termino
 * @property int $precio
 * @property string $imagen
 * @property int $vendidos
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tags
 *
 * @package App\Models
 */
class Producto extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'producto';

	protected $casts = [
		'precio' => 'int',
		'vendidos' => 'int'
	];

	protected $dates = [
		'fecha_inicio',
		'fecha_termino'
	];

	protected $fillable = [
		
		'titulo',
		'descripcion',
		'fecha_inicio',
		'fecha_termino',
		'precio',
		'imagen',
		'vendidos'
	];

	public function tags()
	{
		return $this->belongsToMany(\App\Models\Tag::class, 'producto_tag', 'id_producto', 'id_tag')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function productoTags()
	{
		return $this->hasMany(\App\Models\ProductoTag::class, 'id_producto');
	}
}
