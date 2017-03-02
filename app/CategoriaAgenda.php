<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaAgenda extends Model
{
    protected $table = 'categoriaagenda';
    protected $primaryKey = 'idCategoriaAgenda';

    protected $fillable = ['codigoCategoriaAgenda', 'nombreCategoriaAgenda', 'colorCategoriaAgenda'];

    public $timestamps = false;

    public function categoriaagendacampo()
    {
    	return $this->hasMany('App\CategoriaAgendaCampo','CategoriaAgenda_idCategoriaAgenda');
    }
}