<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionProveedorResultado extends Model
{
	protected $table ='evaluacionproveedorresultado';
	protected $primaryKey = 'idEvaluacionProveedorResultado';
	
	protected $fillable = ['EvaluacionProveedor_idEvaluacionProveedor', 'descripcionEvaluacionProveedorResultado', 'porcentajeEvaluacionProveedorResultado', 'pesoEvaluacionProveedorResultado', 'resultadoEvaluacionProveedorResultado'];

	public $timestamps = false;	
}