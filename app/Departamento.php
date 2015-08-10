<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';
    protected $primaryKey = 'idDepartamento';

    protected $fillable = ['codigoDepartamento', 'nombreDepartamento', 'Pais_idPais'];

    public $timestamps = false;
}
