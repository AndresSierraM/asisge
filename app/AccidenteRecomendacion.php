<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccidenteRecomendacion extends Model
{
    protected $table = 'accidenterecomendacion';
    protected $primaryKey = 'idAccidenteRecomendacion';

    protected $fillable = [
					    'Accidente_idAccidente', 
					    'controlAccidenteRecomendacion', 
					    'fuenteAccidenteRecomendacion', 
					    'medioAccidenteRecomendacion', 
					    'personaAccidenteRecomendacion', 
					    'fechaVerificacionAccidenteRecomendacion', 
					    'medidaEfectivaAccidenteRecomendacion', 
					    'Proceso_idResponsable'
					    ];

    public $timestamps = false;

    public function accidente()
    {
    	return $this->hasMany('App\Accidente','idAccidente');
    }
}