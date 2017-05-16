<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProveedor extends Model
{
	protected $table ='tipoproveedor';
	protected $primaryKey = 'idTipoProveedor';
	
	protected $fillable = ['codigoTipoProveedor', 'nombreTipoProveedor'];

	public $timestamps = false;

	public function tipoProveedorSeleccion() 
	{
		return $this->hasMany('App\TipoProveedorSeleccion','TipoProveedor_idTipoProveedor');
	}

	public function tipoProveedorEvaluacion() 
	{
		return $this->hasMany('App\TipoProveedorEvaluacion','TipoProveedor_idTipoProveedor');
	}
}
	