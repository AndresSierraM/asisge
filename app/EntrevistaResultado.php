<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaResultado extends Model
{
    protected $table ='entrevistaresultado'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaResultado'; //camello
	
	protected $fillable = ['Cargo_idCargo', 'fechaInicialEntrevistaResultado', 'fechaFinalEntrevistaResultado','Tercero_idEntrevistador','estadoEntrevistaResultado','Users_idCrea','fechaElaboracionEntrevistaResultado','Compania_idCompania'];

	public $timestamps = false;

	public function EntrevistaResultadoDetalle()
	{
		return $this->hasMany('App\EntrevistaResultadoDetalle','EntrevistaResultado_idEntrevistaResultado');
    }
}


