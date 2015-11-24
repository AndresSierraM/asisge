<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoInspeccionPregunta extends Model
{
    protected $table = 'tipoinspeccionpregunta';
    protected $primaryKey = 'idtipoInspeccionPregunta';

    protected $fillable = ['numeroTipoInspeccionPregunta','contenidoTipoInspeccionPregunta','TipoInspeccion_idTipoInspeccion'];

    public $timestamps = false;

    public function tipoinspeccion()
    {
		return $this->hasOne('App\TipoInspeccion','idTipoInspeccion');
    }
}
