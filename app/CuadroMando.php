<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuadroMando extends Model
{
    protected $table = 'cuadromando';
    protected $primaryKey = 'idCuadroMando';

    protected $fillable = ['fechaCreacionCuadroMando', 
    						'fechaModificacionCuadroMando', 'Compania_idCompania'];

    public $timestamps = false;

    public function cuadromandoDetalle()
    {
    	return $this->hasMany('App\CuadroMandoDetalle','CuadroMando_idCuadroMando');
    }
}
