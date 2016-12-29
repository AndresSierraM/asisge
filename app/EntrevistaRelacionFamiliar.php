<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaRelacionFamiliar extends Model
{
    
    protected $table ='entrevistarelacionfamiliar'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaRelacionFamiliar'; //camello
	
	protected $fillable = ['Entrevista_idEntrevista','parentescoEntrevistaRelacionFamiliar','relacionEntrevistaRelacionFamiliar'];





	public $timestamps = false;

public function Entrevista()
	{
		return $this->hasOne('App\Entrevista','idEntrevista');
    }



    
}



