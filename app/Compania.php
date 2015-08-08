<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    protected $table = 'compania';
    protected $primaryKey = 'idCompania';

    protected $fillable = ['codigoCompania', 'nombreCompania'];

    public $timestamps = false;
}
