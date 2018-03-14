<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 10 Mar 2018 19:21:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductoTag
 * 
 * @property int $id
 * @property int $id_producto
 * @property int $id_tag
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Producto $producto
 * @property \App\Models\Tag $tag
 *
 * @package App\Models
 */
class ProductoTag extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'producto_tag';

	protected $casts = [
		'id_producto' => 'int',
		'id_tag' => 'int'
	];

	protected $fillable = [
		'id_producto',
		'id_tag'
	];

	public function producto()
	{
		return $this->belongsTo(\App\Models\Producto::class, 'id_producto');
	}

	public function tag()
	{
		return $this->belongsTo(\App\Models\Tag::class, 'id_tag');
	}
}
