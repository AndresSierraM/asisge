<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoSoporte extends Model
{
    protected $table = 'documentosoporte';
    protected $primaryKey = 'idDocumentoSoporte';

    protected $fillable = ['codigoDocumentoSoporte', 'nombreDocumentoSoporte'];

    public $timestamps = false;
}
