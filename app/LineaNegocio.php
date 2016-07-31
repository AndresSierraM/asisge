<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineaNegocio extends Model
{
    protected $table = 'lineanegocio';
    protected $primaryKey = 'idLineaNegocio';

    protected $fillable = ['codigoLineaNegocio', 'nombreLineaNegocio'];

    public $timestamps = false;
}