<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accidente extends Model
{
    protected $table = 'accidente';
    protected $primaryKey = 'idAccidente';

    protected $fillable = ['numeroAccidente',
							'nombreAccidente',
							'clasificacionAccidente',
							'Ausentismo_idAusentismo',
							'Tercero_idCoordinador',
							'firmaCoordinadorAccidente',
							'Tercero_idEmpleado',
							'edadEmpleadoAccidente',
							'tiempoServicioAccidente',
							'Proceso_idProceso',
							'enSuLaborAccidente',
							'laborAccidente',
							'enLaEmpresaAccidente',
							'lugarAccidente',
							'fechaOcurrenciaAccidente',
							'tiempoEnLaborAccidente',
							'tareaDesarrolladaAccidente',
							'descripcionAccidente',
							'observacionTrabajadorAccidente',
							'observacionEmpresaAccidente',
							'agenteYMecanismoAccidente',
							'naturalezaLesionAccidente',
							'parteCuerpoAfectadaAccidente',
							'tipoAccidente',
							'observacionAccidente',
							'Compania_idCompania'];

    public $timestamps = false;

    public function accidenteRecomendacion()
    {
    	return $this->hasMany('App\AccidenteRecomendacion','Accidente_idAccidente');
    }

    public function accidenteEquipo()
    {
    	return $this->hasMany('App\AccidenteEquipo','Accidente_idAccidente');
    }
}