<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRiesgoDetalle extends Model
{
    protected $table = 'tiporiesgodetalle';
    protected $primaryKey = 'idTipoRiesgoDetalle';

    protected $fillable = ['nombreTipoRiesgoDetalle','TipoRiesgo_idTipoRiesgo'];

    public $timestamps = false;

    public function tiporiesgo()
    {
		return $this->hasOne('App\TipoRiesgo','idTipoRiesgo');
    }
}
