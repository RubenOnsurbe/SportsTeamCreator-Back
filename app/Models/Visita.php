<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Club
 * 
 * @property int $id
 * @property Carbon $time
 *
 * @package App\Models
 */
class Visita extends Model
{
    protected $table = 'visitas';
    protected $primaryKey = 'dni';
    public $incrementing = true;
    public $timestamps = true;

    protected $casts = [
        'time' => 'datetime'
    ];

    protected $fillable = [
        'id',
        'time'
    ];

    public static function nuevaVisita()
    {
        $visita = new Visita();
        $visita->time = Carbon::now();
        $visita->save();
    }
    public static function cuantasVisitas()
    {
        $cuantos = Visita::count();
        return $cuantos;
    }
}
