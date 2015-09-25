<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoNormaLegal extends Model
{
    protected $table = 'tiponormalegal';
    protected $primaryKey = 'idTipoNormaLegal';

    protected $fillable = ['codigoTipoNormaLegal', 'nombreTipoNormaLegal'];

    public $timestamps = false;
}
