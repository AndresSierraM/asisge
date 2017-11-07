<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeRol extends Model
{
    protected $table = 'informerol';
    protected $primaryKey = 'idInformeRol';

    protected $fillable = ['Informe_idInforme', 
                            'Rol_idRol'
                            ];

    public $timestamps = false;
}