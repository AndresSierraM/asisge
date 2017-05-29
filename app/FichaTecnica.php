<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    protected $table = 'fichatecnica';
    protected $primaryKey = 'idFichaTecnica';

    protected $fillable = ['', 'tipoFichaTecnica', 'referenciaFichaTecnica', 'referenciaClienteFichaTecnica', 'nombreFichaTecnica', 'fechaCreacionFichaTecnica', 'estadoFichaTecnica', 'LineaProducto_idLineaProducto', 'SublineaProducto_idSublineaProducto', 'Tercero_idTercero', 'observacionFichaTecnica', 'Compania_idCompania'];

    public $timestamps = false;

    public function fichatecnicacriterio() 
	{
		return $this->hasMany('App\FichaTecnicaCriterio','FichaTecnica_idFichaTecnica');
	}

   
}