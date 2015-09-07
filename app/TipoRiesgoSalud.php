<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRiesgoSalud extends Model
{
    protected $table = 'tiporiesgosalud';
    protected $primaryKey = 'idTipoRiesgoSalud';

    protected $fillable = ['nombreTipoRiesgoSalud','TipoRiesgo_idTipoRiesgo'];

    public $timestamps = false;

    public function tiporiesgo()
    {
		return $this->hasOne('App\TipoRiesgo','idTipoRiesgo');
    }
}
