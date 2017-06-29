<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCompra extends Model
{
	protected $table ='recibocompra';
	protected $primaryKey = 'idReciboCompra';
	
	protected $fillable = ['numeroReciboCompra', 'OrdenCompra_idOrdenCompra', 'fechaElaboracionReciboCompra', 'fechaRealReciboCompra', 'Users_idCrea', 'estadoReciboCompra', 'observacionReciboCompra'];

	public $timestamps = false;	
}