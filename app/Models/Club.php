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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The table associated with the model.
     * 
     * @var string
     */
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

    public static function unirseAClub($data){

        $tokenSession = new TokenSession();

        if($tokenSession->comprobarToken($data)){

            $existencias = Club::where('nombre', $data['nombre'])
                    ->where('codigoAcceso', $data['codigoAcceso'])
                    ->first();

            $response = array("unirseExito"=>false);
        
            if($existencias !== null){
            
                $usuarioClub = new Usuarioclub();
                $usuarioClub->dni = $data['dni'];
                $usuarioClub->id_club = $existencias->id_club;
                if($usuarioClub->save()){
                    $response['unirseExito']=true;
                }

            }
    }

        return $response;
    }

    public static function crearClub($data){

        $club = new self();

        // Asignamos los valores correspondientes
        $club->nombre = $data['nombre'];
        $club->codigoAcceso = $data['codigoAcceso'];
        $club->localizacion = $data['localizacion'];

        if($club->save()){

            $usuarioClub = new Usuarioclub();
            $usuarioClub->dni = $data['dni'];
            $usuarioClub->id_club = $club->id_club;
            $usuarioClub->rolClub = "administrador";
            $usuarioClub->save();
            return true;

        }else{
            return false;
        }
    }
    
}

