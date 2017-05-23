<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProveedorSeleccion extends Model
{
	protected $table ='tipoproveedorseleccion';
	protected $primaryKey = 'idTipoProveedorSeleccion';
	
	protected $fillable = ['TipoProveedor_idTipoProveedor', 'descripcionTipoProveedorSeleccion'];

	public $timestamps = false;

	public function tipoproveedor() 
	{
		return $this->hasOne('App\TipoProveedor','idTipoProveedor');
	}
}
	