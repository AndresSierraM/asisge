<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCRM extends Model
{
    protected $table = 'movimientocrm';
    protected $primaryKey = 'idMovimientoCRM';

    protected $fillable = [
 'numeroMovimientoCRM', 'asuntoMovimientoCRM', 'fechaSolicitudMovimientoCRM', 'fechaEstimadaSolucionMovimientoCRM', 'fechaVencimientoMovimientoCRM', 'fechaRealSolucionMovimientoCRM', 'prioridadMovimientoCRM', 'diasEstimadosSolucionMovimientoCRM', 'diasRealesSolucionMovimientoCRM', 'Tercero_idSolicitante', 'Tercero_idSupervisor', 'Tercero_idAsesor', 'CategoriaCRM_idCategoriaCRM', 'DocumentoCRM_idDocumentoCRM', 'LineaNegocio_idLineaNegocio', 'OrigenCRM_idOrigenCRM', 'EstadoCRM_idEstadoCRM', 'AcuerdoServicio_idAcuerdoServicio'
    ];

    public $timestamps = false;
}
