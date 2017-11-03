<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ausentismo extends Model
{
    protected $table = 'ausentismo';
    protected $primaryKey = 'idAusentismo';

    protected $fillable = ['Tercero_idTercero', 'nombreAusentismo', 'fechaElaboracionAusentismo', 
    						'tipoAusentismo','fechaInicioAusentismo',
    						'fechaFinAusentismo','archivoAusentismo','diasAusentismo','horasAusentismo','CentroCosto_idCentroCosto', 'Compania_idCompania'];

    public $timestamps = false;
}
