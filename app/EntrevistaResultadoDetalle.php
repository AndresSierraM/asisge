<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaResultadoDetalle extends Model
{
    protected $table ='entrevistaresultadodetalle'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaResultadoDetalle'; //camello
	
	protected $fillable = ['EntrevistaResultado_idEntrevistaResultado', 'Entrevista_idEntrevista'];

	public $timestamps = false;

	public function EntrevistaResultado()
	{
		return $this->hasOne('App\EntrevistaResultado','idEntrevistaResultado');
    }

    public function Entrevista()
	{
		return $this->hasOne('App\Entrevista','idEntrevista');
    }
}


