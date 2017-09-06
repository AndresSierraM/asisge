<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoSeguimientoCalibracionArchivo extends Model
{
    protected $table = 'equiposeguimientocalibracionarchivo';
    protected $primaryKey = 'idEquipoSeguimientoCalibracionArchivo';

    protected $fillable = ['EquipoSeguimientoCalibracion_idEquipoSeguimientoCalibracion','rutaEquipoSeguimientoCalibracionArchivo'];

    public $timestamps = false;

    
}
