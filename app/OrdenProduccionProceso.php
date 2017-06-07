<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenProduccionProceso extends Model
{
    protected $table = 'ordenproduccionproceso';
    protected $primaryKey = 'idOrdenProduccionProceso';

    protected $fillable = ['OrdenProduccion_idOrdenProduccion', 'Proceso_idProceso', 'ordenOrdenProduccionProceso', 'observacionOrdenProduccionProceso'];

    public $timestamps = false;

    
}