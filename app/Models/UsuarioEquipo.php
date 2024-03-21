<?php

namespace App\Models;

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

    /**
     * @var array
     */
    protected $fillable = ['dorsal', 'funcion', 'rol', 'fechaAlta'];

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
}
