<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosticoPregunta extends Model
{
    protected $table = 'diagnosticopregunta';
    protected $primaryKey = 'idDiagnosticoPregunta';

    protected $fillable = ['ordenDiagnosticoPregunta','detalleDiagnosticoPregunta'];

    public $timestamps = false;

    public function diagnosticoGrupo()
    {
		return $this->hasOne('App\DiagnosticoGrupo','idDiagnosticoGrupo');
    }
}
