<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table = 'informe';
    protected $primaryKey = 'idInforme';

    protected $fillable = ['nombreInforme', 'descripcionInforme', 'vistaPreviaInforme', 'CategoriaInforme_idCategoriaInforme' ];

    public $timestamps = false;

  
}