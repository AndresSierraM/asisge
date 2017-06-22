<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCompraResultado extends Model
{
	protected $table ='recibocompraresultado';
	protected $primaryKey = 'idReciboCompraResultado';
	
	protected $fillable = ['ReciboCompra_idReciboCompra', 'descripcionReciboCompraResultado', 'valorCompraReciboCompraResultado', 'valorReciboReciboCompraResultado', 'diferenciaReciboCompraResultado', 'porcentajeReciboCompraResultado', 'pesoReciboCompraResultado', 'resultadoReciboCompraResultado'];

	public $timestamps = false;	
}