<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TokenSession
 * 
 * @property int $id
 * @property string $dni
 * @property string $token_session
 * @property Carbon $fecha_creacion
 * 
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class TokenSession extends Model
{
	protected $table = 'token_session';
	public $timestamps = false;

	protected $casts = [
		'fecha_creacion' => 'datetime'
	];

	protected $fillable = [
		'dni',
		'token_session',
		'fecha_creacion'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'dni');
	}



	public static function comprobarToken($data){

		if(isset($data['token_session']) && isset($data['dni'])){
			$tokenSession = TokenSession::where('token_session', $data['token_session'])
                                ->where('dni', $data['dni'])
                                ->first();

		if($tokenSession){
			return true;
		}else return false;
		
		}else return false;
		
	}
}
