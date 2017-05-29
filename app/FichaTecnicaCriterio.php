<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaCriterio extends Model
{
	protected $table ='fichatecnicacriterio';
	protected $primaryKey = 'idFichaTecnicaCriterio';
	
	protected $fillable = ['descripcionFichaTecnicaCriterio', 'FichaTecnica_idFichaTecnica'];

	public $timestamps = false;	

	public function fichatecnica()
    {
    	return $this->hasOne('App\FichaTecnica','idFichaTecnica');
    }
}