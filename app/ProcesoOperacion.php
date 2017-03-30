<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcesoOperacion extends Model
{
    protected $table = 'procesooperacion';
    protected $primaryKey = 'idProcesoOperacion';

    protected $fillable = ['Proceso_idProceso', 'ordenProcesoOperacion', 'nombreProcesoOperacion', 
    						'samProcesoOperacion', 'observacionProcesoOperacion'];

    public $timestamps = false;

    function Proceso()
    {
    	return $this->hasMany('App\Proceso','idProceso');
    }
}