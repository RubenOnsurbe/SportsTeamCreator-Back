<?php

namespace App\Models;
use App\Models\Usuarioclub;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_club
 * @property string $nombre
 * @property string $codigoAcceso
 * @property string $localizacion
 * @property string $fechaCreacion
 * @property Equipo[] $equipos
 * @property Evento[] $eventos
 * @property Usuarioclub[] $usuarioclubs
 */
class Club extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'club';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_club';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'codigoAcceso', 'localizacion', 'fechaCreacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipos()
    {
        return $this->hasMany('App\Models\Equipo', 'id_club', 'id_club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventos()
    {
        return $this->hasMany('App\Models\Evento', 'id_club', 'id_club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarioclubs()
    {
        return $this->hasMany('App\Models\Usuarioclub', 'id_club', 'id_club');
    }

    public function UnirseClub($data){

        $existencias = Club::where('id_club', $data['id_club'])->where('codigoAcceso', $data['codigoAcceso'])->first();

        if(count($existencias) >= 1){
           
            $usuarioClub = new Usuarioclub();
            $usuarioClub->dni = $data['dni'];
            $usuarioClub->id_club = $data['id_club'];
            $usuarioClub->save();
        }
        
    }
}
