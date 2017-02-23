<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilCargo extends Model
{
    protected $table ='perfilcargo'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idPerfilCargo'; //camello
	
	protected $fillable = ['tipoPerfilCargo', 'nombrePerfilCargo', 'observacionPerfilCargo','Compania_idCompania'];

	public $timestamps = false;

	 public function EvaluacionDesempenioEducacion()
    {
        return $this->hasMany('App\EvaluacionDesempenioEducacion','PerfilCargo_idRequerido');
    }
    public function EvaluacionDesempenioFormacion()
    {
        return $this->hasMany('App\EvaluacionDesempenioFormacion','PerfilCargo_idRequerido');
    }
  	 public function EvaluacionDesempenioHabilidad()
    {
        return $this->hasMany('App\EvaluacionDesempenioHabilidad','PerfilCargo_idRequerido');
    }
}


