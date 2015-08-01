<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';
    protected $primaryKey = 'idPais';

    protected $fillable = ['codigoPais', 'nombrePais'];

    public $timestamps = false;
}
