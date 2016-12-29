<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaHijo extends Model
{
    
    protected $table ='entrevistahijo'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaHijo'; //camello
	
	protected $fillable = ['Entrevista_idEntrevista','nombreEntrevistaHijo','edadEntrevistaHijo','ocupacionEntrevistaHijo'];



	public $timestamps = false;

public function Entrevista()
	{
		return $this->hasOne('App\Entrevista','idEntrevista');
    }



    
}



