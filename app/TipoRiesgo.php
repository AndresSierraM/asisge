<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRiesgo extends Model
{
    protected $table = 'tiporiesgo';
    protected $primaryKey = 'idTipoRiesgo';

    protected $fillable = ['codigoTipoRiesgo','nombreTipoRiesgo','origenTipoRiesgo','ClasificacionRiesgo_idClasificacionRiesgo'];

    public $timestamps = false;

    public function tipoRiesgoDetalles()
    {
		return $this->hasMany('App\TipoRiesgoDetalle','TipoRiesgo_idTipoRiesgo');
    }

    public function tipoRiesgoSaluds()
    {
		return $this->hasMany('App\TipoRiesgoSalud','TipoRiesgo_idTipoRiesgo');
    }
}
