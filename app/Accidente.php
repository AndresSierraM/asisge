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
							'Tercero_idCoordinador',
							'enSuLaborAccidente',
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
							'agenteLesionAccidente',
							'tipoAccidente',
							'arbolCausasAccidente',
							'observacionAccidente'];

    public $timestamps = false;
}