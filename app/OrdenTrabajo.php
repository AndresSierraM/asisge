<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'ordentrabajo';
    protected $primaryKey = 'idOrdenTrabajo';

    protected $fillable = ['numeroOrdenTrabajo', 'fechaElaboracionOrdenTrabajo', 'OrdenProduccion_idOrdenProduccion', 'Proceso_idProceso', 'cantidadOrdenTrabajo', 'observacionOrdenTrabajo', 'estadoOrdenTrabajo', 'Compania_idCompania'];

    public $timestamps = false;
   
}