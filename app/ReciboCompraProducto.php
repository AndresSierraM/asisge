<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCompraProducto extends Model
{
	protected $table ='recibocompraproducto';
	protected $primaryKey = 'idReciboCompraProducto';
	
	protected $fillable = ['ReciboCompra_idReciboCompra', 'FichaTecnica_idFichaTecnica', 'cantidadReciboCompraProducto', 'TipoCalidad_idTipoCalidad', 'valorUnitarioReciboCompraProducto'];

	public $timestamps = false;	
}