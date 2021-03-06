<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoResponsabilidad extends Model
{
     protected $table ='cargoresponsabilidad'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idCargoResponsabilidad'; //camello
	
	protected $fillable = ['idCargoResponsabilidad ','descripcionCargoResponsabilidad','rendicionCuentasCargoResponsabilidad','Cargo_idCargo','porcentajeCargoResponsabilidad'];

	public $timestamps = false;

	public function Cargo()
	{
		return $this->hasOne('App\Cargo','idCargo');
    }

    public function EvaluacionDesempenioResponsabilidad()
	{
		return $this->hasMany('App\EvaluacionDesempenioResponsabilidad','CargoResponsabilidad_idCargoResponsabilidad');
    }
   }
