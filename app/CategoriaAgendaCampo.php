<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaAgendaCampo extends Model
{
    protected $table = 'categoriaagendacampo';
    protected $primaryKey = 'idCategoriaAgendaCampo';

    protected $fillable = ['CategoriaAgenda_idCategoriaAgenda', 'CampoCRM_idCampoCRM', 'obligatorioCategoriaAgendaCampo'];

    public $timestamps = false;

    public function categoriaagenda()
    {
    	return $this->hasOne('App\CategoriaAgenda','CategoriaAgenda_idCategoriaAgenda');
    }

}