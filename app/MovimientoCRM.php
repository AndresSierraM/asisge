<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCRM extends Model
{
    protected $table = 'movimientocrm';
    protected $primaryKey = 'idMovimientoCRM';

    protected $fillable = [
 	'numeroMovimientoCRM', 'asuntoMovimientoCRM', 'fechaSolicitudMovimientoCRM', 'fechaEstimadaSolucionMovimientoCRM', 'fechaVencimientoMovimientoCRM', 'fechaRealSolucionMovimientoCRM', 'prioridadMovimientoCRM', 'diasEstimadosSolucionMovimientoCRM', 'diasRealesSolucionMovimientoCRM', 'Tercero_idSolicitante', 'Tercero_idSupervisor', 'Tercero_idAsesor', 'CategoriaCRM_idCategoriaCRM', 'DocumentoCRM_idDocumentoCRM', 'LineaNegocio_idLineaNegocio', 'OrigenCRM_idOrigenCRM', 'EstadoCRM_idEstadoCRM', 'AcuerdoServicio_idAcuerdoServicio', 'EventoCRM_idEventoCRM', 'detallesMovimientoCRM', 'solucionMovimientoCRM', 'valorMovimientoCRM', 'Compania_idCompania'
    ];

    public $timestamps = false;

    public function movimientoCRMAsistentes()
    {
        return $this->hasMany('App\MovimientoCRMAsistente','MovimientoCRM_idMovimientoCRM');
    }

    public function movimientoCRMArchivos()
    {
        return $this->hasMany('App\MovimientoCRMArchivo','MovimientoCRM_idMovimientoCRM');
    }

    public function AcuerdoServicio()
    {
        return $this->hasOne('App\AcuerdoServicio','idAcuerdoServicio');
    }

    public function OrigenCRM()
    {
        return $this->hasOne('App\OrigenCRM','idOrigenCRM');
    }
    
    public function TerceroSolicitante()
    {
        return $this->hasOne('App\Tercero','idTercero');
    }
    
    public function TerceroSupervisor()
    {
        return $this->hasOne('App\Tercero','idTercero');
    }

    public function TerceroAsesor()
    {
        return $this->hasOne('App\Tercero','idTercero');
    }

    public function CategoriaCRM()
    {
        return $this->hasOne('App\CategoriaCRM','idCategoriaCRM');
    }

    
    public function EventoCRM()
    {
        return $this->hasOne('App\EventoCRM','idEventoCRM');
    }

    public function LineaNegocio()
    {
        return $this->hasOne('App\LineaNegocio','idLineaNegocio');
    }

    
    
}
