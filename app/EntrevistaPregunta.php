<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaPregunta extends Model
{
    
    protected $table ='entrevistapregunta'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaPregunta'; //camello
	
	protected $fillable = ['fechaNacimientoEntrevistaPregunta','edadEntrevistaPregunta','estadoCivilEntrevistaPregunta','telefonoEntrevistaPregunta','movilEntrevistaPregunta','correoElectronicoEntrevistaPregunta','direccionEntrevistaPregunta','Ciudad_idResidencia','nombreConyugeEntrevistaPregunta','ocupacionConyugeEntrevistaPregunta','numeroHijosEntrevistaPregunta','conQuienViveEntrevistaPregunta','dondeViveEntrevistaPregunta','ocupacionActualEntrevistaPregunta','estudioActualEntrevistaPregunta','horarioEstudioEntrevistaPregunta','motivacionCarreraEntrevistaPregunta','expectativaEstudioEntrevistaPregunta','ultimoEmpleoEntrevistaPregunta','funcionesEmpleoEntrevistaPregunta','logrosEmpleoEntrevistaPregunta','ultimoSalarioEntrevistaPregunta','motivoRetiroEntrevistaPregunta','expectativaLaboralEntrevistaPregunta','disponibilidadInicioEntrevistaPregunta','aspiracionSalarialEntrevistaPregunta','motivacionTrabajoEntrevistaPregunta','proyeccion5AñosEntrevistaPregunta','tiempoLibreEntrevistaPregunta','introvertidoEntrevistaPregunta','vicioEntrevistaPregunta','antecedentesEntrevistaPregunta','anecdotaEntrevistaPregunta','observacionEntrevistaPregunta','Entrevista_idEntrevista'];


// este va despues de fehca nacimiento entrevista pregunta edadEntrevistaPregunta


	public $timestamps = false;

public function Entrevista()
	{
		return $this->hasOne('App\Entrevista','idEntrevista');
    }



    
}



