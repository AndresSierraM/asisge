<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = 'proceso';
    protected $primaryKey = 'idProceso';

    protected $fillable = ['codigoProceso', 'nombreProceso', 'Compania_idCompania'];

    public $timestamps = false;
}