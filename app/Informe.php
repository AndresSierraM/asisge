<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table = 'informe';
    protected $primaryKey = 'idInforme';

    protected $fillable = ['nombreInforme', 'descripcionInforme', 'tipoInforme', 'CategoriaInforme_idCategoriaInforme', 
                            'SistemaInformacion_idSistemaInformacion', 'vistaInforme' ];

    public $timestamps = false;

  
}