<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoDetalle extends Model
{
    protected $table = 'ordentrabajodetalle';
    protected $primaryKey = 'idOrdenTrabajoDetalle';

    protected $fillable = ['OrdenTrabajo_idOrdenTrabajo', 'TipoCalidad_idTipoCalidad', 'cantidadOrdenTrabajoDetalle'];

    public $timestamps = false;

    
}