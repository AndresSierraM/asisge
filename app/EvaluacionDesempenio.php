<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDesempenio extends Model
{
    protected $table ='evaluaciondesempenio'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEvaluacionDesempenio'; //camello
	
	protected $fillable = ['Tercero_idEmpleado', 'Cargo_idCargo', 'Tercero_idResponsable','fechaElaboracionEvaluacionDesempenio','observacionEvaluacionDesempenio'];

	public $timestamps = false;

	public function Tercero()
    {
        return $this->hasOne('App\Tercero','idTercero');
    }
    public function Cargo()
    {
        return $this->hasOne('App\Cargo','idCargo');
    }

    public function EvaluacionDesempenioResponsabilidad()
    {
        return $this->hasMany('App\EvaluacionDesempenioResponsabilidad','EvaluacionDesempenio_idEvaluacionDesempenio');
    }
 	public function EvaluacionDesempenioEducacion()
    {
        return $this->hasMany('App\EvaluacionDesempenioEducacion','EvaluacionDesempenio_idEvaluacionDesempenio');
    }
    public function EvaluacionDesempenioFormacion()
    {
        return $this->hasMany('App\EvaluacionDesempenioFormacion','EvaluacionDesempenio_idEvaluacionDesempenio');
    }
    public function EvaluacionDesempenioHabilidad()
    {
        return $this->hasMany('App\EvaluacionDesempenioHabilidad','EvaluacionDesempenio_idEvaluacionDesempenio');
    }







}


