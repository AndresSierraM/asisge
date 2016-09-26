<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregaElementoProteccion extends Model
{
	protected $table ='entregaelementoproteccion';
	protected $primaryKey = 'idEntregaElementoProteccion';
	
	protected $fillable = ['Tercero_idTercero', 'firmaTerceroEntregaElementoProteccion', 'fechaEntregaElementoProteccion', 'Compania_idCompania'];

	public $timestamps = false;

	public function entregaelementoprotecciondetalles()
	{
		return $this->hasMany('App\EntregaElementoProteccionDetalle',
		'EntregaElementoProteccion_idEntregaElementoProteccion');
	}

	public function Tercero()
	{
		return $this->hasOne('App\Tercero','idTercero');
	}
	
}
	