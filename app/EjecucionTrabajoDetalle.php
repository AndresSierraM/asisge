<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EjecucionTrabajoDetalle extends Model
{
    protected $table = 'ejecuciontrabajodetalle';
    protected $primaryKey = 'idEjecucionTrabajoDetalle';

    protected $fillable = ['idEjecucionTrabajoDetalle',
                            'EjecucionTrabajo_idEjecucionTrabajo',
                            'TipoCalidad_idTipoCalidad',
                            'cantidadEjecucionTrabajoDetalle'];

    public $timestamps = false;
   
}