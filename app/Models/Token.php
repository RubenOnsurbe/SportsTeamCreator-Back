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


	public static function coincideTokenConCorreo($data){

		$tokenValido = Token::where('correo', $data['correo'])
                         ->where('token', $data['token'])
                         ->first();

    // Si se encuentra un token válido, devolver true; de lo contrario, devolver false
    return $tokenValido ? "true" : "false";
	}	
}
