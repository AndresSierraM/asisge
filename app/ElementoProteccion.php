<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementoProteccion extends Model
{
    protected $table = 'elementoproteccion';
    protected $primaryKey = 'idElementoProteccion';

    protected $fillable = ['codigoElementoProteccion', 
						    'nombreElementoProteccion', 
						    'TipoElementoProteccion_idTipoElementoProteccion', 
						    'normaElementoProteccion', 
						    'descripcionElementoProteccion', 
						    'procesosElementoProteccion', 
						    'imagenElementoProteccion'
						  ];

    public $timestamps = false;

    public function entregaelementoprotecciondetalles()
	{
		return 'hola';
		return $this->hasMany('App\EntregaElementoProteccionDetalle',
		'ElementoProteccion_idElementoProteccion');
	}

    
}