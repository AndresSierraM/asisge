<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    
    protected $table ='entrevista'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevista'; //camello
	
	protected $fillable = ['documentoAspiranteEntrevista','estadoEntrevista','nombre1AspiranteEntrevista','nombre2AspiranteEntrevista','apellido1AspiranteEntrevista','apellido2AspiranteEntrevista','Tercero_idAspirante','fechaEntrevista','Tercero_idEntrevistador','Cargo_idCargo','experienciaAspiranteEntrevista','experienciaRequeridaEntrevista']; 





	public $timestamps = false;

public function EntrevistaEducacion()
	{
		return $this->hasMany('App\EntrevistaEducacion','Entrevista_idEntrevista');
    }


    public function EntrevistaFormacion()
	{
		return $this->hasMany('App\EntrevistaFormacion','Entrevista_idEntrevista');
    }
    public function EntrevistaPregunta()
	{
		return $this->hasOne('App\EntrevistaPregunta','Entrevista_idEntrevista');
    }

    public function EntrevistaHijo()	
	{
		return $this->hasMany('App\EntrevistaHijo','Entrevista_idEntrevista');
    }



public function EntrevistaRelacionFamiliar()
	{
		return $this->hasMany('App\EntrevistaRelacionFamiliar','Entrevista_idEntrevista');
    }


public function EntrevistaCompetencia()
	{
		return $this->hasMany('App\EntrevistaCompetencia','Entrevista_idEntrevista');
    }

// public function CompetenciaRespuesta()
// 	{
// 		return $this->hasMany('App\CompetenciaRespuesta','Competencia_idCompetencia');
//     }



 //      public function EntrevistaHabilidad()
	// {
	// 	return $this->hasMany('App\EntrevistaHabilidad','Entrevista_idEntrevista');
 //    }


 //      public function Tercero()
	// {
	// 	return $this->hasOne('App\Tercero','Tercero_idTercero');
 //    }


    
}



