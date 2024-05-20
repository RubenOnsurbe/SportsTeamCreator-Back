<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Club;
use App\Models\Usuarioclub;
use App\Models\Usuarioequipo;
use App\Models\Usuario;

/**
 * @property integer $id
 * @property integer $id_club
 * @property integer $id_equipo
 * @property string $dni
 * @property string $titulo
 * @property string $descripcion
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property string $tipo
 * @property string $ubicacion
 * @property Club $club
 * @property Usuario[] $usuarios
 */
class Evento extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'evento';

    /**
     * @var array
     */
    protected $fillable = ['id_club', 'titulo', 'descripcion', 'fechaInicio', 'fechaFin', 'tipo', 'ubicacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo('App\Models\Club', 'id_club', 'id_club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usuarios()
    {
        return $this->belongsToMany('App\Models\Usuario', 'usuarioevento', 'id_evento', 'dni');
    }



    public static function obtenerEventosDeUsuario($data)
    {
        if ($data['tipo'] === 'todos') {
            $eventos = Evento::where('dni', $data['dni'])->get();
        } else {
            $eventos = Evento::where('dni', $data['dni'])->where('tipo', $data['tipo'])->get();
        }
        return $eventos;
    }

    public static function obetenerEventosDeClub($data)
    {
        if ($data['tipo'] === 'todos') {
            $eventos = Evento::where('id_club', $data['id_club'])->get();
        } else {
            $eventos = Evento::where('id_club', $data['id_club'])->where('tipo', $data['tipo'])->get();
        }
        return $eventos;
    }

    public static function obtenerEventosDeEquipo($data)
    {
        if ($data['tipo'] === 'todos') {
            $eventos = Evento::where('id_equipo', $data['id_equipo'])->get();
        } else {
            $eventos = Evento::where('id_equipo', $data['id_equipo'])->where('tipo', $data['tipo'])->get();
        }
        return $eventos;
    }

    public static function crearEvento($data)
    {
        if (isset($data['id_equipo']) && !isset($data['id_club']) && !isset($data['dni'])) {
            $evento = new Evento();
            $evento->id_equipo = $data['id_equipo'];
            $evento->titulo = $data['titulo'];
            $evento->descripcion = $data['descripcion'];
            $evento->fechaInicio = $data['fechaInicio'];
            $evento->fechaFin = $data['fechaFin'];
            $evento->tipo = $data['tipo'];
            $evento->ubicacion = $data['ubicacion'];
            $evento->save();
            return $evento;
        } else if (isset($data['id_club']) && !isset($data['id_equipo']) && !isset($data['dni'])) {
            $evento = new Evento();
            $evento->id_club = $data['id_club'];
            $evento->titulo = $data['titulo'];
            $evento->descripcion = $data['descripcion'];
            $evento->fechaInicio = $data['fechaInicio'];
            $evento->fechaFin = $data['fechaFin'];
            $evento->tipo = $data['tipo'];
            $evento->ubicacion = $data['ubicacion'];
            $evento->save();
            return $evento;
        } else if (isset($data['dni']) && !isset($data['id_club']) && !isset($data['id_equipo'])) {
            $evento = new Evento();
            $evento->dni = $data['dni'];
            $evento->titulo = $data['titulo'];
            $evento->descripcion = $data['descripcion'];
            $evento->fechaInicio = $data['fechaInicio'];
            $evento->fechaFin = $data['fechaFin'];
            $evento->tipo = $data['tipo'];
            $evento->ubicacion = $data['ubicacion'];
            $evento->save();
        }

    }


    public static function borrarEvento($data)
    {
        $evento = Evento::where('id', $data['idEvento'])->first();
        if ($evento->delete()) {
            return true;
        } else {
            return false;
        }
    }







    /*CONSULTA EN SQL: 
SELECT evento.titulo 
FROM evento
LEFT JOIN usuarioevento ON evento.id = usuarioevento.id_evento
LEFT JOIN usuarioequipo ON evento.id_equipo = usuarioequipo.id_equipo
LEFT JOIN equipo ON evento.id_equipo = equipo.id_equipo
WHERE usuarioequipo.dni_usuario ='02795855K' OR usuarioevento.dni='02795855K';
*/



}
