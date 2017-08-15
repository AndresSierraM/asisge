<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoSeguimientoDetalle extends Model
{
    protected $table = 'EquipoSeguimientoDetalle';
    protected $primaryKey = 'idEquipoSeguimientoDetalle';

    protected $fillable = ['EquipoSeguimiento_idEquipoSeguimiento','identificacionEquipoSeguimientoDetalle','tipoEquipoSeguimientoDetalle', 'FrecuenciaMedicion_idCalibracion','fechaInicioCalibracionEquipoSeguimientoDetalle','FrecuenciaMedicion_idVerificacion','fechaInicioVerificacionEquipoSeguimientoDetalle','unidadMedidaCalibracionEquipoSeguimientoDetalle','rangoInicialCalibracionEquipoSeguimientoDetalle','rangoFinalCalibracionEquipoSeguimientoDetalle','escalaCalibracionEquipoSeguimientoDetalle','capacidadInicialCalibracionEquipoSeguimientoDetalle','capacidadFinalCalibracionEquipoSeguimientoDetalle','utilizacionCalibracionEquipoSeguimientoDetalle','toleranciaCalibracionEquipoSeguimientoDetalle','errorPermitidoCalibracionEquipoSeguimientoDetalle'];

    public $timestamps = false;

    public function EquipoSeguimiento()
    {
		return $this->hasOne('App\EquipoSeguimiento','idEquipoSeguimiento');
    }
}
