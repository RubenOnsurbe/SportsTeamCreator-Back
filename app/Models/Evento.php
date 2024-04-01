<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property integer $id_club
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



    public static function obtenerEventosDeUsuario($dni) {
        $eventos = DB::table('evento')
                    ->leftJoin('usuarioevento', function($join) use ($dni) {
                        $join->on('evento.id', '=', 'usuarioevento.id_evento')
                             ->where('usuarioevento.dni', '=', $dni);
                    })
                    ->leftJoin('usuarioequipo', function($join) use ($dni) {
                        $join->on('evento.id_equipo', '=', 'usuarioequipo.id_equipo')
                             ->where('usuarioequipo.dni_usuario', '=', $dni);
                    })
                    ->leftJoin('equipo', 'evento.id_equipo', '=', 'equipo.id_equipo')
                    ->select('evento.*') // Selecciona todos los campos de la tabla evento
                    ->where(function($query) {
                        $query->whereNotNull('usuarioevento.id_evento')
                              ->orWhereNotNull('usuarioequipo.id_equipo');
                    })
                    ->get();
    
        return $eventos;
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
