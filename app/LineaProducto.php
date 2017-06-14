<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineaProducto extends Model
{
    protected $table = 'lineaproducto';
    protected $primaryKey = 'idLineaProducto';

    protected $fillable = ['codigoLineaProducto', 'nombreLineaProducto', 'Compania_idCompania'];

    public $timestamps = false;

   
   public function SublineaProducto()
	{
		return $this->hasMany('App\SublineaProducto','LineaProducto_idLineaProducto');
    }
}