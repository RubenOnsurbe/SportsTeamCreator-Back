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
 * @property string $rolClub
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

	public static function getClubs($data)
	{
		$id_clubes = Usuarioclub::where('dni', $data['dni'])->pluck('id_club');
		$clubes = Club::whereIn('id_club', $id_clubes)->get();
		return $clubes;
	}

	public static function getRoles($data)
	{
		$roles = Usuarioclub::where('dni', $data['dni'])->where('id_club', $data['id_club'])->pluck('rolClub');
		return $roles;
	}

	public static function jugadoresClub($data)
	{
		$jugadores = Usuarioclub::where('id_club', $data['id_club'])->get();
		return $jugadores;
	}

	public static function comprobarUsuarioPerteneceClub($data){

		$resultado = Usuarioclub::where('dni', $data['dni'])
                     ->where('id_club', $data['id_club'])
                     ->first();

		if($resultado) return $resultado['nombre'];
		else return false;
	}

}
