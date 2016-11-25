<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoInspeccionPregunta extends Model
{
    protected $table = 'tipoinspeccionpregunta';
    protected $primaryKey = 'idTipoInspeccionPregunta';

    protected $fillable = ['numeroTipoInspeccionPregunta','contenidoTipoInspeccionPregunta','TipoInspeccion_idTipoInspeccion'];

    public $timestamps = false;

    public function tipoinspeccion()
    {
		return $this->hasOne('App\TipoInspeccion','idTipoInspeccion');
    }
}
