<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SublineaProducto extends Model
{
    protected $table = 'sublineaproducto';
    protected $primaryKey = 'idSublineaProducto';

    protected $fillable = ['LineaProducto_idLineaProducto','codigoSublineaProducto', 'nombreSublineaProducto'];

    public $timestamps = false;

   
   public function LineaProducto()
	{
		return $this->hasOne('App\LineaProducto','idLineaProducto');
    }
}