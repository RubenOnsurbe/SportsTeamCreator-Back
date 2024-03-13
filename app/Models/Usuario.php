<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

/**
 * Class Usuario
 * 
 * @property string $dni
 * @property string $nombre
 * @property string $apellidos
 * @property string $correo
 * @property string $contrasena
 * @property Carbon $fechaNacimiento
 * @property Carbon $fechaCreacion
 * 
 * @property Collection|Club[] $clubs
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuario';
	protected $primaryKey = 'dni';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaNacimiento' => 'datetime',
		'fechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'nombre',
		'apellidos',
		'correo',
		'contrasena',
		'fechaNacimiento',
		'fechaCreacion'
	];

	public function clubs()
	{
		return $this->belongsToMany(Club::class, 'usuarioclub', 'dni', 'id_club');
	}


	public static function crearUsuario($data)
	{
		$respuesta = array();

		$data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
		try {
			self::insert($data);
		} catch (QueryException $e) {
			//Si no se crea usuario...



			if ($e->getCode() === '23000') {
				//integrity constraint violation 


				//Si dni existe...
				if (strpos($e->getMessage(), 'PRIMARY') == true)
					array_push($respuesta, "dni");

				//Si el correo se repite
				if (strpos($e->getMessage(), 'correo') == true) {
					array_push($respuesta, "correo");
				}


			}

		}

		return $respuesta;

	}





	public static function iniciarSesion($data)
	{

		$respuesta = array();

		//Usuario con el correo que proporciona el usuario

		$usuario = Usuario::where('correo', $data['correo'])->first();

		if ($usuario == null) {
			array_push($respuesta, "correo");
		} else {

			if (password_verify($data['contrasena'], $usuario->contrasena) == false)
				array_push($respuesta, "contrasena");

		}

		if (count($respuesta) == 0) {
			array_push($respuesta, $usuario->dni);
		}
		return $respuesta;





	}

}