<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoInspeccion extends Model
{
    protected $table = 'tipoinspeccion';
    protected $primaryKey = 'idTipoInspeccion';

    protected $fillable = ['codigoTipoInspeccion','nombreTipoInspeccion','FrecuenciaMedicion_idFrecuenciaMedicion'];

    public $timestamps = false;

    public function tipoInspeccionPreguntas()
    {
		return $this->hasMany('App\tipoInspeccionPregunta','TipoInspeccion_idTipoInspeccion');
    }

    
}
