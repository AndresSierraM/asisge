<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico2 extends Model
{
    protected $table = 'diagnostico2';
    protected $primaryKey = 'idDiagnostico2';

    protected $fillable = ['codigoDiagnostico2', 'nombreDiagnostico2', 'fechaElaboracionDiagnostico2', 
    						'equiposCriticosDiagnostico2', 'herramientasCriticasDiagnostico2', 
    						'observacionesDiagnostico2', 'Compania_idCompania'];

    public $timestamps = false;

    public function diagnostico2Detalle()
    {
    	return $this->hasMany('App\Diagnostico2Detalle','Diagnostico2_idDiagnostico2');
    }
}
