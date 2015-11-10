<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramaDetalle extends Model
{
    protected $table = 'programadetalle';
    protected $primaryKey = 'idProgramaDetalle';

    protected $fillable = ['Programa_idPrograma', 'actividadProgramaDetalle', 
                            'Tercero_idResponsable', 'fechaPlaneadaProgramaDetalle',
                            'Documento_idDocumento', 'recursoPlaneadoProgramaDetalle',
                            'recursoEjecutadoProgramaDetalle', 'fechaEjecucionProgramaDetalle',
                            'observacionProgramaDetalle'];

    public $timestamps = false;

    public function programa()
    {
		return $this->hasOne('App\Programa','idPrograma');
    }
}
