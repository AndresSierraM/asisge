<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenProduccionMaterial extends Model
{
    protected $table = 'ordenproduccionmaterial';
    protected $primaryKey = 'idOrdenProduccionMaterial';

    protected $fillable = ['OrdenProduccion_idOrdenProduccion', 'FichaTecnica_idMaterial', 'consumoUnitarioOrdenProduccionMaterial', 'consumoTotalOrdenProduccionMaterial'];

    public $timestamps = false;

    
}