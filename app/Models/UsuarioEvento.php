<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $dni
 * @property integer $id_evento
 * @property Usuario $usuario
 * @property Evento $evento
 */
class UsuarioEvento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuarioevento';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'dni', 'dni');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'id_evento');
    }
}
