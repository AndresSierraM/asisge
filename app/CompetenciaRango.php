<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenciaRango extends Model
{
    protected $table ='competenciarango'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idCompetenciaRango'; //camello
	
	protected $fillable = ['ordenCompetenciaRango', 'nivelCompetenciaRango', 'desdeCompetenciaRango','hastaCompetenciaRango'];

	public $timestamps = false;


}


