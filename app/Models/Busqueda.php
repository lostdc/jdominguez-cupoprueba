<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Mar 2018 00:44:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Busqueda
 * 
 * @property int $id
 * @property string $palabra
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $productos
 *
 * @package App\Models
 */
class Busqueda extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'busqueda';

	protected $fillable = [
		'palabra'
	];

	public function productos()
	{
		return $this->belongsToMany(\App\Models\Producto::class, 'producto_busqueda', 'id_busqueda', 'id_producto')
					->withPivot('id', 'cantidad', 'deleted_at')
					->withTimestamps();
	}
}
