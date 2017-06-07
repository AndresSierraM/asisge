<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenProduccionMaterial extends Model
{
    protected $table = 'ordenproduccionmaterial';
    protected $primaryKey = 'idOrdenProduccionMaterial';

    protected $fillable = ['OrdenProduccion_idOrdenProduccion', 'nombreOrdenProduccionMaterial', 'consumoUnitarioOrdenProduccionMaterial', 'consumoTotalOrdenProduccionMaterial'];

    public $timestamps = false;

    
}