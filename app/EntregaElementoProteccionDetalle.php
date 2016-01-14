<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregaElementoProteccionDetalle extends Model
{
	protected $table ='entregaelementoprotecciondetalle';
	protected $primaryKey = 'idEntregaElementoProteccionDetalle';
	
	protected $fillable = ['ElementoProteccion_idElementoProteccion',
	'cantidadEntregaElementoProteccionDetalle','EntregaElementoProteccion_idEntregaElementoProteccion'];

	public $timestamps = false;

	public function ElementoProteccion()
	{
		return $this->hasOne('App\ElementoProteccion','idElementoProteccion');
	}

	public function EntregaElementoProteccion()
	{
		return $this->hasOne('App\EntregaElementoProteccion','idEntregaElementoProteccion');
	}

	
}
	