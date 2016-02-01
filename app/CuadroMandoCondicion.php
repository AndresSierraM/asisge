<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuadroMandoCondicion extends Model
{
    protected $table = 'cuadromandocondicion';
    protected $primaryKey = 'idCuadroMandoCondicion';

    protected $fillable = ['CuadroMandoFormula_idCuadroMandoFormula', 'parentesisInicioCuadroMandoCondicion', 'campoCuadromandoCondicion', 'operadorCuadroMandoCondicion', 'valorCuadroMandoCondicion', 'parentesisFinCuadroMandoCondicion', 'conectorCuadroMandoCondicion'];

    public $timestamps = false;

    public function cuadromandoformula()
    {
    	return $this->hasMany('App\CuadroMandoFormula', 'idCuadroMandoFormula')
    }
}
