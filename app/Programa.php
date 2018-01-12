<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $table = 'programa';
    protected $primaryKey = 'idPrograma';

    protected $fillable = ['nombrePrograma', 'fechaElaboracionPrograma', 
    						'ClasificacionRiesgo_idClasificacionRiesgo', 'alcancePrograma', 
    						'CompaniaObjetivo_idCompaniaObjetivo', 'objetivoEspecificoPrograma',
                            'Tercero_idElabora', 'generalidadPrograma', 'Compania_idCompania'];

    public $timestamps = false;

    public function programaDetalle()
    {
    	return $this->hasMany('App\ProgramaDetalle','Programa_idPrograma');
    }

     public function ProgramaArchivo()
    {
        return $this->hasMany('App\ProgramaArchivo','Programa_idPrograma');
    }
}
