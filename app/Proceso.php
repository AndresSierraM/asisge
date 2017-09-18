<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = 'proceso';
    protected $primaryKey = 'idProceso';

    protected $fillable = ['codigoProceso', 'nombreProceso','tipoProceso', 'Compania_idCompania'];

    public $timestamps = false;

    function ProcesoOperacion()
    {
    	return $this->hasMany('App\ProcesoOperacion','Proceso_idProceso');
    }
}
