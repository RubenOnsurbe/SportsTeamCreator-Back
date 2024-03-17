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

	public static function obtenerClubes($data)
	{
		$dni = $data;

		$clubs = Usuarioclub::where('dni', $dni)->get();

		$clubsUsuario = Club::whereIn('id_club', $clubs->pluck('id_club'))->get();

		return $clubsUsuario;
	}

	public static function crearClub($data)
	{
		$respuesta = array();
		$club = new Club();
		$club->nombre = $data['nombre'];
		$club->usuarioClub = $data['usuarioClub'];
		$club->codigoAcceso = password_hash($data['codigoAcceso'], PASSWORD_DEFAULT);

		try {
			$club->save();
			$usuarioClub = new Usuarioclub();
			$usuarioClub->dni = $data['DNI'];
			$usuarioClub->id_club = $club->id_club;
			$usuarioClub->save();
		} catch (QueryException $e) {
			if ($e->getCode() === '23000') {
				array_push($respuesta, "Ya existe un club con ese nombre");
			}
		}
		return $respuesta;

	}

	public static function unirseAClub($data)
	{
		$respuesta = array();

		$club = Club::where('usuarioClub', $data['usuarioClub'])->first();
		if ($club == null) {
			array_push($respuesta, "club");
		} else {
			$usuarioClub = Usuarioclub::where('id_club', $club->id_club)
				->where('dni', $data['DNI'])
				->first();
			if ($usuarioClub != null) {
				array_push($respuesta, "club2");
			} else {
				if (password_verify($data['codigoAcceso'], $club->codigoAcceso) == false)
					array_push($respuesta, "codigoAcceso");
			}

		}
		if (count($respuesta) == 0) {
			$usuarioClub2 = new Usuarioclub();
			$usuarioClub2->dni = $data['DNI'];
			$usuarioClub2->id_club = $club->id_club;
			$usuarioClub2->save();

		}
		return $respuesta;
	}

	public static function dejarClub($data)
	{
		$club = Usuarioclub::where('dni', $data['DNI'])
			->where('id_club', $data['id_club'])
			->delete();
		return true;
	}

	public function cuantosUsuarios()
	{
		$cuantos = Usuario::count();
		return $cuantos;
	}

}