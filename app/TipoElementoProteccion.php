<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoElementoProteccion extends Model
{
    protected $table = 'tipoelementoproteccion';
    protected $primaryKey = 'idTipoElementoProteccion';

    protected $fillable = ['codigoTipoElementoProteccion',
							'nombreTipoElementoProteccion',
							'observacionTipoElementoProteccion',
							'Compania_idCompania'];

    public $timestamps = false;

    
}