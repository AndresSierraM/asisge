<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EjecucionTrabajo extends Model
{
    protected $table = 'ejecuciontrabajo';
    protected $primaryKey = 'idEjecucionTrabajo';

    protected $fillable = ['idEjecucionTrabajo',
                            'numeroEjecucionTrabajo',
                            'fechaElaboracionEjecucionTrabajo',
                            'OrdenTrabajo_idOrdenTrabajo',
                            'cantidadEjecucionTrabajo',
                            'observacionEjecucionTrabajo',
                            'Compania_idCompania'];

    public $timestamps = false;
   
}