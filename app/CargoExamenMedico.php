<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoExamenMedico extends Model
{
    protected $table = 'cargoexamenmedico';
    protected $primaryKey = 'idCargoExamenMedico';

    protected $fillable = ['Cargo_idCargo', 'ListaGeneral_idExamenMedico', 'ingresoCargoExamenMedico', 'retiroCargoExamenMedico', 'periodicoCargoExamenMedico', 'FrecuenciaMedicion_idFrecuenciaMedicion'];

    public $timestamps = false;

    public function cargo()
    {
		return $this->hasOne('App\Cargo','idCargo');
    }
}
