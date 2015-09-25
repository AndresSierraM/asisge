<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpideNormaLegal extends Model
{
    protected $table = 'expidenormalegal';
    protected $primaryKey = 'idExpideNormaLegal';

    protected $fillable = ['codigoExpideNormaLegal', 'nombreExpideNormaLegal'];

    public $timestamps = false;
}
