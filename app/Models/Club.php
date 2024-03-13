<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Club
 * 
 * @property int $id_club
 * @property string $nombre
 * @property string $codigoAcceso
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Club extends Model
{
	protected $table = 'club';
	protected $primaryKey = 'id_club';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'codigoAcceso'
	];

	public function usuarios()
	{
		return $this->belongsToMany(Usuario::class, 'usuarioclub', 'id_club', 'dni');
	}
}
