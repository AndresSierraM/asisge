<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    protected $primaryKey = 'idDocumento';

    protected $fillable = ['codigoDocumento', 'nombreDocumento'];

    public $timestamps = false;
}
