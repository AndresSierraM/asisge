<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeCompania extends Model
{
    protected $table = 'informecompania';
    protected $primaryKey = 'idInformeCompania';

    protected $fillable = ['Informe_idInforme', 
                            'Compania_idCompania'
                            ];

    public $timestamps = false;
}