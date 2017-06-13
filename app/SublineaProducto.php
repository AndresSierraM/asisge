<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SublineaProducto extends Model
{
    protected $table = 'sublineaproducto';
    protected $primaryKey = 'idSublineaProducto';

    protected $fillable = ['LineaProducto_idLineaProducto','codigoSublineaProducto', 'nombreSublineaProducto', 'Compania_idCompania'];

    public $timestamps = false;

   
   public function LineaProducto()
	{
		return $this->hasMany('App\LineaProducto','idLineaProducto');
    }
}