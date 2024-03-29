<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuarioclub
 * 
 * @property string $dni
 * @property int $id_club
 * 
 * @property Usuario $usuario
 * @property Club $club
 *
 * @package App\Models
 */
class Usuarioclub extends Model
{
	protected $table = 'usuarioclub';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_club' => 'int'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'dni');
	}

	public function club()
	{
		return $this->belongsTo(Club::class, 'id_club');
	}
}
