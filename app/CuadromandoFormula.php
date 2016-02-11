<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuadroMandoFormula extends Model
{
    protected $table = 'cuadromandoformula';
    protected $primaryKey = 'idCuadroMandoFormula';

    protected $fillable = ['CuadroMando_idCuadroMando', 'tipoCuadroMandoFormula', 'CuadroMando_idIndicador', 'nombreCuadroMandoFormula', 'Modulo_idModulo', 'campoCuadroMandoFormula', 'calculoCuadroMandoFormula'];

    public $timestamps = false;

    public function cuadromandocondicion()
    {
    	return $this->hasMany('App\CuadroMandoCondicion', 'CuadroMandoFormula_idCuadroMandoFormula');
    }

    public function cuadromandoagrupador()
    {
    	return $this->hasMany('App\CuadroMandoAgrupador', 'CuadroMandoFormula_idCuadroMandoFormula');
    }
}
