<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticoGrupo extends Model
{
    protected $table = 'diagnosticogrupo';
    protected $primaryKey = 'idDiagnosticoGrupo';

    protected $fillable = ['nombreDiagnosticoGrupo'];

    public $timestamps = false;

    public function diagnosticoPregunta()
    {
    	return $this->hasMany('App\DiagnosticoPregunta','DiagnosticoGrupo_idDiagnosticoGrupo');
    }
}
