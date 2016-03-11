<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteACPM extends Model
{
    protected $table = 'reporteacpm';
    protected $primaryKey = 'idReporteACPM';

    protected $fillable = ['numeroReporteACPM', 'fechaElaboracionReporteACPM', 'descripcionReporteACPM', 'Compania_idCompania'];

    public $timestamps = false;

    function reporteACPMDetalles()
    {
		return $this->hasMany('App\ReporteACPMDetalle','ReporteACPM_idReporteACPM');
    }
}
