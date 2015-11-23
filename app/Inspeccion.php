<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    protected $table = 'inspeccion';
    protected $primaryKey = 'idInspeccion';

    protected $fillable = ['TipoInspeccion_idTipoInspeccion', 'Tercero_idRealizadaPor', 'fechaElaboracionInspeccion', 
    						'observacionesInspeccion'];

    public $timestamps = false;

    public function inspeccionDetalle()
    {
    	return $this->hasMany('App\InspeccionDetalle','Inspeccion_idInspeccion');
    }
}
