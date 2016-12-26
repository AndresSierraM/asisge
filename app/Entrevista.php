<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    
    protected $table ='entrevista'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevista'; //camello
	
	protected $fillable = ['documentoAspiranteEntrevista', 'estadoEntrevista', 'nombre1AspiranteEntrevista','nombre2AspiranteEntrevista','apellido1AspiranteEntrevista','apellido2AspiranteEntrevista','Tercero_idAspirante', 'fechaEntrevista', 'Tercero_idEntrevistador','Cargo_idCargo','experienciaAspiranteEntrevista','experienciaRequeridaEntrevista','fechaNacimientoEntrevistaPregunta','edadEntrevistaPregunta','estadoCivilEntrevistaPregunta','telefonoEntrevistaPregunta','movilEntrevistaPregunta','correoElectronicoEntrevistaPregunta','direccionEntrevistaPregunta','Ciudad_idResidencia','nombreConyugeEntrevistaPregunta','ocupacionConyugeEntrevistaPregunta','numeroHijosEntrevistaPregunta','conQuienViveEntrevistaPregunta','dondeViveEntrevistaPregunta','ocupacionActualEntrevistaPregunta','','','','','','','','','','','','','',''];



	public $timestamps = false;

public function EntrevistaEducacion()
	{
		return $this->hasMany('App\EntrevistaEducacion','Entrevista_idEntrevista');
    }


    public function EntrevistaFormacion()
	{
		return $this->hasMany('App\EntrevistaFormacion','Entrevista_idEntrevista');
    }
    public function EntrevistaHabilidad()
	{
		return $this->hasMany('App\EntrevistaHabilidad','Entrevista_idEntrevista');
    }

      public function EntrevistaHabilidad()
	{
		return $this->hasMany('App\EntrevistaHabilidad','Entrevista_idEntrevista');
    }


 //      public function Tercero()
	// {
	// 	return $this->hasOne('App\Tercero','Tercero_idTercero');
 //    }


    
}



