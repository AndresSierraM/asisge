<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizRiesgo extends Model
{
    protected $table = 'matrizriesgo';
    protected $primaryKey = 'idMatrizRiesgo';

    protected $fillable = ['nombreMatrizRiesgo','fechaElaboracionMatrizRiesgo','Users_id'];

    public $timestamps = false;

    public function matrizRiesgoDetalles()
    {
		return $this->hasMany('App\MatrizRiesgoDetalle','MatrizRiesgo_idMatrizRiesgo');
    }
}
