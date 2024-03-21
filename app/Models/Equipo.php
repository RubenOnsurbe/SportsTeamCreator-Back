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
}
