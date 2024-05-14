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
use Illuminate\Support\Str;
use App\Models\TokenSession;


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
		$usuario = new Usuario();

		$usuario->dni = $data['dni'];
		$usuario->apellidos = $data['apellidos'];
		$usuario->nombre = $data['nombre'];
		$usuario->correo = $data['correo'];
		$usuario->contrasena = password_hash($data['contrasena'], PASSWORD_DEFAULT);
		$usuario->imagen = $data['imagen'];
		$usuario->fechaNacimiento = $data['fecha'];
		$usuario->save();
		return "Ok";
	}
	

	public static function iniciarSesion($data)
	{
		$respuesta = array(
			"contrasena" => "",
			"correo" => "",
			"ok" => "",
			"dni" => "",
			"nombre" => ""
		);
		//Usuario con el correo que proporciona el usuario
		$usuario = Usuario::where('correo', $data['correo'])->first();
		if ($usuario == null) {
			//Si el correo no existe, se añade correo como error a la respuesta
			$respuesta['correo'] = 'correoIncorrecto';
		} else {

			//Si la contraseña no corresponde, se añade el error a la respuesta
			if (password_verify($data['contrasena'], $usuario->contrasena) == false) {
				$respuesta['contrasena'] = 'contrasenaIncorrecta';
			} else {
				$respuesta['ok'] = 'ok';
				$respuesta['dni'] = $usuario['dni'];
				$respuesta['token'] = Str::random(60);
				$respuesta['nombre'] = $usuario["nombre"];
				//Guardamos el token de usuario en mysql (se borrara pasado un dia):
				$tokenSession = new TokenSession([
					'dni' => $respuesta['dni'],
					'token_session' => $respuesta['token'],

				]);
				$tokenSession->save();
			}
		}
		return $respuesta;

		//Si se devuelve un array vacio esque inicio correctamente
	}

	public function cuantosUsuarios()
	{
		$cuantos = Usuario::count();
		return $cuantos;
	}

	public static function obtenerInfo($data)
	{
		if (TokenSession::comprobarToken($data)) {
			$usuario = Usuario::where('dni', $data['dni'])->first();

			return $usuario;
		} else {
			return "error";
		}


	}

	public static function modificarUsuario($data)
	{
		if (TokenSession::comprobarToken($data)) {

			$usuario = Usuario::where('dni', $data['dni'])->first();
			$usuario->correo = $data['correo'];
			$usuario->nombre = $data['nombre'];
			$usuario->apellidos = $data['apellidos'];
			try {
				$usuario->save();
				return 'ok';
			} catch (\Exception $e) {
				return 'correoExiste';
			}
		} else {
			return 'no';
		}
	}

	public static function nombreJugador($data)
	{
		$jugador = Usuario::where('dni', $data['dni'])->first();
		return $jugador;
	}

}