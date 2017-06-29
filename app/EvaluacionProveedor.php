<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionProveedor extends Model
{
	protected $table ='evaluacionproveedor';
	protected $primaryKey = 'idEvaluacionProveedor';
	
	protected $fillable = ['Tercero_idProveedor', 'fechaElaboracionEvaluacionProveedor', 'fechaInicialEvaluacionProveedor', 'fechaFinalEvaluacionProveedor', 'Users_idCrea', 'observacionEvaluacionProveedor'];

	public $timestamps = false;	
}