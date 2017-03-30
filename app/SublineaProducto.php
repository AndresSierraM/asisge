<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SublineaProducto extends Model
{
    protected $table = 'sublineaproducto';
    protected $primaryKey = 'idSublineaProducto';

    protected $fillable = ['codigoSublineaProducto', 'nombreSublineaProducto', 'Compania_idCompania'];

    public $timestamps = false;

   
}