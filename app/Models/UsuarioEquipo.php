<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $dni_usuario
 * @property integer $id_equipo
 * @property integer $dorsal
 * @property string $funcion
 * @property string $rol
 * @property string $fechaAlta
 * @property Equipo $equipo
 * @property Usuario $usuario
 */
class UsuarioEquipo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuarioequipo';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['funcion', 'fechaAlta', 'dni_usuario', 'id_equipo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo()
    {
        return $this->belongsTo('App\Models\Equipo', 'id_equipo', 'id_equipo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'dni_usuario', 'dni');
    }
    public static function getEquipos($criteria)
    {
        return self::where($criteria)->get(); // Adjust this query as per actual requirements
    }
    public static function unirseEquipo($data)
    {
        $usuarioEquipo = new UsuarioEquipo();
        $usuarioEquipo->dni_usuario = $data['dni_usuario'];
        $usuarioEquipo->id_equipo = $data['id_equipo'];
        $usuarioEquipo->funcion = "jugador";
        $usuarioEquipo->rol = "Usuario";
        $usuarioEquipo->dorsal = 0;
        $usuarioEquipo->fechaAlta = date('Y-m-d');
        $usuarioEquipo->save();
        return true;
    }
    public static function jugadoresEquipo($data)
    {
        $jugadores = UsuarioEquipo::where('id_equipo', $data['id_equipo'])->get();
        return $jugadores;
    }
    public static function expulsarJugadorEquipo($data)
    {
        UsuarioEquipo::where('dni_usuario', $data['dni_usuario'])->where('id_equipo', $data['id_equipo'])->delete();
        return true;
    }
    public static function cambiarRolEquipo($data)
    {
        DB::table('usuarioEquipo')
            ->where('dni_usuario', $data['dni_usuario'])
            ->where('id_equipo', $data['id_equipo'])
            ->update(['rol' => $data['rol']]);
        return "Ok";
    }
    public static function cambiarDorsalEquipo($data)
    {
        DB::table('usuarioEquipo')
            ->where('dni_usuario', $data['dni_usuario'])
            ->where('id_equipo', $data['id_equipo'])
            ->update(['dorsal' => $data['dorsal']]);
        return "Ok";
    }
    public static function cambiarFuncionEquipo($data)
    {
        DB::table('usuarioEquipo')
            ->where('dni_usuario', $data['dni_usuario'])
            ->where('id_equipo', $data['id_equipo'])
            ->update(['funcion' => $data['funcion']]);
        return "Ok";
    }
}

