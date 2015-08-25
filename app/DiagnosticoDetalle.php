<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticoDetalle extends Model
{
    protected $table = 'diagnosticodetalle';
    protected $primaryKey = 'idDiagnosticoDetalle';

    protected $fillable = ['puntuacionDiagnosticoDetalle','resultadoDiagnosticoDetalle',
    						'mejoraDiagnosticoDetalle','DiagnosticoPregunta_idDiagnosticoPregunta',
    						'Diagnostico_idDiagnostico'];

    public $timestamps = false;

    public function diagnostico()
    {
		return $this->hasOne('App\Diagnostico','idDiagnostico');
    }
}
