<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $table = 'indicador';
    protected $primaryKey = 'idIndicador';

    protected $fillable = ['CuadroMando_idCuadroMando', 'fechaCorteIndicador', 
    						'Compania_idCompania','fechaCalculoIndicador','valorIndicador'];

    public $timestamps = false;
    
}
