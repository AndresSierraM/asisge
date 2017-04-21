<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCalidad extends Model
{
    protected $table = 'tipocalidad';
    protected $primaryKey = 'idTipoCalidad';

    protected $fillable = ['codigoTipoCalidad', 'nombreTipoCalidad', 'noConformeTipoCalidad', 'alertaCorreoTipoCalidad', 'paraTipoCalidad', 'asuntoTipoCalidad', 'mensajeTipoCalidad', 'Compania_idCompania'];

    public $timestamps = false;

   
}