<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActoInseguro extends Model
{
    
    protected $table ='actoinseguro'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idActoInseguro'; //camello
	
	protected $fillable = ['Tercero_idEmpleadoReporta','fechaElaboracionActoInseguro','descripcionActoInseguro','consecuenciasActoInseguro','estadoActoInseguro','fechaSolucionActoInseguro','Tercero_idEmpleadoSoluciona']; 

	public $timestamps = false;

// public function EntrevistaEducacion()
// 	{
// 		return $this->hasMany('App\EntrevistaEducacion','Entrevista_idEntrevista');
//     }

    
}



