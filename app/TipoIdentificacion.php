<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{
    protected $table = 'tipoidentificacion';
    protected $primaryKey = 'idTipoIdentificacion';

    protected $fillable = ['codigoTipoIdentificacion', 'nombreTipoIdentificacion'];

    public $timestamps = false;
}
