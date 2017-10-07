<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaInforme extends Model
{
    protected $table = 'categoriainforme';
    protected $primaryKey = 'idCategoriaInforme';

    protected $fillable = ['nombreCategoriaInforme', 'observacionCategoriaInforme'];

    public $timestamps = false;

  
}