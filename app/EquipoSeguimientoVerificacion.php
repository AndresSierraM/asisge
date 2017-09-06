<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoSeguimientoVerificacion extends Model
{
    protected $table = 'equiposeguimientoverificacion';
    protected $primaryKey = 'idEquipoSeguimientoVerificacion';

    protected $fillable = ['fechaEquipoSeguimientoVerificacion','EquipoSeguimiento_idEquipoSeguimiento','EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle', 'errorEncontradoEquipoSeguimientoVerificacion','resultadoEquipoSeguimientoVerificacion','accionEquipoSeguimientoVerificacion'];

    public $timestamps = false;

}
