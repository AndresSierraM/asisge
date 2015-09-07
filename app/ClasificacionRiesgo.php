<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasificacionRiesgo extends Model
{
    protected $table = 'clasificacionriesgo';
    protected $primaryKey = 'idClasificacionRiesgo';

    protected $fillable = ['codigoClasificacionRiesgo', 'nombreClasificacionRiesgo'];

    public $timestamps = false;
}
