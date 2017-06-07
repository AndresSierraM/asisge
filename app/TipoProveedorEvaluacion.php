<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProveedorEvaluacion extends Model
{
	protected $table ='tipoproveedorevaluacion';
	protected $primaryKey = 'idTipoProveedorEvaluacion';
	
	protected $fillable = ['TipoProveedor_idTipoProveedor', 'descripcionTipoProveedorEvaluacion', 'pesoTipoProveedorEvaluacion'];

	public $timestamps = false;

	public function tipoproveedor() 
	{
		return $this->hasOne('App\TipoProveedor','idTipoProveedor');
	}
}
	