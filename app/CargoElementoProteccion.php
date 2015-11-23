<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoElementoProteccion extends Model
{
    protected $table = 'cargoelementoproteccion';
    protected $primaryKey = 'idCargoElementoProteccion';

    protected $fillable = ['Cargo_idCargo', 'ListaGeneral_idElementoProteccion'];

    public $timestamps = false;

    public function cargo()
    {
		return $this->hasOne('App\Cargo','idCargo');
    }
}
