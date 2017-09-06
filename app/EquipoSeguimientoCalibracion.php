<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoSeguimientoCalibracion extends Model
{
    protected $table = 'equiposeguimientocalibracion';
    protected $primaryKey = 'idEquipoSeguimientoCalibracion';

    protected $fillable = ['fechaEquipoSeguimientoCalibracion','EquipoSeguimiento_idEquipoSeguimiento','EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle', 'errorEncontradoEquipoSeguimientoCalibracion','resultadoEquipoSeguimientoCalibracion','Tercero_idProveedor','accionEquipoSeguimientoCalibracion'];

    public $timestamps = false;

}
