<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuadroMandoCondicion extends Model
{
    protected $table = 'cuadromandoagrupador';
    protected $primaryKey = 'idCuadroMandoAgrupador';

    protected $fillable = ['CuadroMandoFormula_idCuadroMandoFormula', 'campoCuadroMandoAgrupador'];

    public $timestamps = false;

    public function cuadromandoformula()
    {
    	return $this->hasMany('App\CuadroMandoFormula', 'idCuadroMandoFormula')
    }
}
