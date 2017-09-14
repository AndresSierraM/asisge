<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizRiesgoActualizacion extends Model
{
    protected $table = 'matrizriesgoactualizacion';
    protected $primaryKey = 'idMatrizRiesgoActualizacion';

    protected $fillable = ['fechaMatrizRiesgoActualizacion','MatrizRiesgo_idMatrizRiesgo'];

    public $timestamps = false;

}
