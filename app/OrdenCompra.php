<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
	protected $table ='ordencompra';
	protected $primaryKey = 'idOrdenCompra';
	
	protected $fillable = ['DocumentoCRM_idDocumentoCRM', 'numeroOrdenCompra', 'requerimientoOrdenCompra', 'sitioEntregaOrdenCompra', 'fechaElaboracionOrdenCompra', 'fechaEstimadaOrdenCompra', 'fechaVencimientoOrdenCompra', 'Tercero_idProveedor', 'Tercero_idSolicitante', 'Tercero_idAutorizador', 'estadoOrdenCompra', 'observacionOrdenCompra', 'Compania_idCompania'];

	public $timestamps = false;	
}