<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaHabilidad extends Model
{
    protected $table ='entrevistahabilidad'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaHabilidad'; //camello
	
	protected $fillable = ['PerfilCargo_idRequerido','PerfilCargo_idAspirante','calificacionEntrevistaHabilidad','Entrevista_idEntrevista'];


	public $timestamps = false;

	public function Entrevista()
	{
		return $this->hasMany('App\Entrevista','idEntrevista');
    }
}
