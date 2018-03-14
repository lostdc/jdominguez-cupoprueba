<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 10 Mar 2018 19:21:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Tag
 * 
 * @property int $id
 * @property string $nombre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $productos
 *
 * @package App\Models
 */
class Tag extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'tag';

	protected $fillable = [
		'nombre'
	];

	public function productos()
	{
		return $this->belongsToMany(\App\Models\Producto::class, 'producto_tag', 'id_tag', 'id_producto')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
