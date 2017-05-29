<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCRMProducto extends Model
{
	protected $table ='movimientocrmproducto';
	protected $primaryKey = 'idMovimientoCRMProducto';
	
	protected $fillable = ['FichaTecnica_idFichaTecnica', 'cantidadMovimientoCRMProducto', 'valorUnitarioMovimientoCRMProducto', 'MovimientoCRM_idMovimientoCRM'];

	public $timestamps = false;	
}