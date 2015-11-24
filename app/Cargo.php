<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';
    protected $primaryKey = 'idCargo';
    protected $fillable = ['codigoCargo', 'nombreCargo', 'salarioBaseCargo', 'nivelRiesgoCargo', 'objetivoCargo', 'educacionCargo', 'experienciaCargo', 'formacionCargo', 'posicionPredominanteCargo', 'restriccionesCargo', 'habilidadesCargo', 'responsabilidadesCargo', 'autoridadesCargo'];
    public $timestamps = false;

    public function cargoElementoProtecciones()
    {
    	return $this->hasMany('App\CargoElementoProteccion','Cargo_idCargo');
    }

    public function cargoExamenMedicos()
    {
    	return $this->hasMany('App\CargoExamenMedico','Cargo_idCargo');
    }

    public function cargoTareaRiesgos()
    {
    	return $this->hasMany('App\CargoTareaRiesgo','Cargo_idCargo');
    }

    public function cargoVacunas()
    {
    	return $this->hasMany('App\CargoVacuna','Cargo_idCargo');
    }
}
