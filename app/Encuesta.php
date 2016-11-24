<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuesta';
    protected $primaryKey = 'idEncuesta';

    protected $fillable = ['tituloEncuesta', 
						    'descripcionEncuesta', 
						    'Compania_idCompania'
						  ];

    public $timestamps = false;

    public function EncuestaPregunta()
	{
		return $this->hasMany('App\EncuestaPregunta','Encuesta_idEncuesta');
	}
}
