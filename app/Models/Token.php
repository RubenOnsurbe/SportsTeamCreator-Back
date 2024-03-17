<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * 
 * @property string $correo
 * @property string|null $token
 * 
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class Token extends Model
{
	protected $table = 'token';
	protected $primaryKey = 'correo';
	public $incrementing = false;
	public $timestamps = false;

	

	protected $fillable = [
        'correo',
		'token'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'correo', 'correo');
	}
}
