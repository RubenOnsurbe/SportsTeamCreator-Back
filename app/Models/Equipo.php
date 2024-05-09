<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_equipo
 * @property integer $id_club
 * @property string $nombre
 * @property string $categoria
 * @property string $genero
 * @property string $fechaCreacion
 * @property Club $club
 * @property Usuarioequipo[] $usuarioequipos
 */
class Equipo extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'equipo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_equipo';

    /**
     * @var array
     */
    protected $fillable = ['id_club', 'nombre', 'categoria', 'genero', 'fechaCreacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo('App\Models\Club', 'id_club', 'id_club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarioequipos()
    {
        return $this->hasMany('App\Models\Usuarioequipo', 'id_equipo', 'id_equipo');
    }

    public static function EquiposUsuario($data)
    {
        $id_usuario = $data['dni'];
        $club = $data['id_club'];
        $equiposTodos = UsuarioEquipo::where('dni_usuario', $id_usuario)->get();
        $equiposIds = $equiposTodos->pluck('id_equipo');
        $equipos = Equipo::whereIn('id_equipo', $equiposIds)->where('id_club', $club)->get();

        return $equipos;
    }

    public static function obtenerDatosEquipo($data)
    {
        $id_equipo = $data['id_equipo'];
        $equipo = Equipo::where('id_equipo', $id_equipo)->first();
        return $equipo;
    }
    public static function modificarEquipo($data)
    {
        $equipo = Equipo::where('id_equipo', $data['id_equipo'])->first();
        $equipo->nombre = $data['nombre'];
        $equipo->categoria = $data['categoria'];
        $equipo->genero = $data['genero'];
        if ($equipo->save()) {
            return true;
        } else {
            return false;
        }
    }

    public static function equiposClub($data)
    {
        $club = $data['id_club'];
        $equipos = Equipo::where('id_club', $club)->get();
        return $equipos;
    }

    public static function crearEquipo($data)
    {
        $equipo = new Equipo();
        $equipo->id_club = $data['id_club'];
        $equipo->nombre = $data['nombre'];
        $equipo->categoria = $data['categoria'];
        $equipo->genero = $data['genero'];
        $equipo->fechaCreacion = date('Y-m-d');
        if ($equipo->save()) {
            return true;
        } else {
            return false;
        }
    }
}
