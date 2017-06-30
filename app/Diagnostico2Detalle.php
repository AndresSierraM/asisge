<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico2Detalle extends Model
{
    protected $table = 'diagnostico2detalle';
    protected $primaryKey = 'idDiagnostico2Detalle';

    protected $fillable = ['DiagnosticoNivel4_idDiagnosticoNivel4','puntuacionDiagnostico2Detalle','respuestaDiagnostico2Detalle','resultadoDiagnostico2Detalle','mejoraDiagnostico2Detalle','Diagnostico2_idDiagnostico2'];

    public $timestamps = false;

    public function Diagnostico2()
    {
		return $this->hasOne('App\Diagnostico2','idDiagnostico2');
    }
}
