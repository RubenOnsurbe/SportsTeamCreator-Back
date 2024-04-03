<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Models\Usuarioclub;
use App\Models\Club;


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
 * @property string $genero

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
		'fechaCreacion',
		'genero'
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
			//Si el correo no existe, se añade correo como error a la respuesta
			array_push($respuesta, "correo");
		} else {

			//Si la contraseña no corresponde, se añade el error a la respuesta
			if (password_verify($data['contrasena'], $usuario->contrasena) == false)
				array_push($respuesta, "contrasena");
		}
		if (count($respuesta) == 0) {
			array_push($respuesta, $usuario->dni);
			session()->put("DNI", $usuario->dni);
		}
		return $respuesta;
		//Si se devuelve un array vacio esque inicio correctamente
	}

	public function cuantosUsuarios()
	{
		$cuantos = Usuario::count();
		return $cuantos;
	}

}