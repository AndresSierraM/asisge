<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeccionDetalle extends Model
{
    protected $table = 'inspecciondetalle';
    protected $primaryKey = 'idInspeccionDetalle';

    protected $fillable = ['Inspeccion_idInspeccion','TipoInspeccionPregunta_idTipoInspeccionPregunta',
    						'situacionInspeccionDetalle','fotoInspeccionDetalle',
    						'ubicacionInspeccionDetalle', 'accionMejoraInspeccionDetalle','Tercero_idResponsable',
                            'fechaInspeccionDetalle', 'observacionInspeccionDetalle'];

    public $timestamps = false;

    public function inspeccion()
    {
		return $this->hasOne('App\Inspeccion','idInspeccion');
    }
}
