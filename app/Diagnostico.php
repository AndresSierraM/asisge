<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnostico';
    protected $primaryKey = 'idDiagnostico';

    protected $fillable = ['codigoDiagnostico', 'nombreDiagnostico', 'fechaElaboracionDiagnostico', 
    						'equiposCriticosDiagnostico', 'herramientasCriticasDiagnostico', 
    						'observacionesDiagnostico', 'Compania_idCompania'];

    public $timestamps = false;

    public function diagnosticoDetalle()
    {
    	return $this->hasMany('App\DiagnosticoDetalle','Diagnostico_idDiagnostico');
    }
}
