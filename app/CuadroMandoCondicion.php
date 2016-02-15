<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuadroMandoCondicion extends Model
{
    protected $table = 'cuadromandocondicion';
    protected $primaryKey = 'idCuadroMandoCondicion';

    protected $fillable = ['CuadroMandoFormula_idCuadroMandoFormula', 'parentesisInicioCuadroMandoCondicion', 'campoCuadroMandoCondicion', 'operadorCuadroMandoCondicion', 'valorCuadroMandoCondicion', 'parentesisFinCuadroMandoCondicion', 'conectorCuadroMandoCondicion'];

    public $timestamps = false;

    public function cuadromandoformula()
    {
    	return $this->hasOne('App\CuadroMandoFormula', 'CuadroMandoFormula_idCuadroMandoFormula');
    }
}
