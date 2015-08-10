<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudad';
    protected $primaryKey = 'idCiudad';

    protected $fillable = ['codigoCiudad', 'nombreCiudad', 'Departamento_idDepartamento'];

    public $timestamps = false;
}
