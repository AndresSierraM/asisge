<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenCompraProducto extends Model
{
	protected $table ='ordencompraproducto';
	protected $primaryKey = 'idOrdenCompraProducto';
	
	protected $fillable = ['FichaTecnica_idFichaTecnica', 'cantidadOrdenCompraProducto', 'valorUnitarioOrdenCompraProducto', 'MovimientoCRM_idMovimientoCRM', 'OrdenCompra_idOrdenCompra'];

	public $timestamps = false;	
}