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
						    'imagenElementoProteccion',
						    'Compania_idCompania'
						  ];

    public $timestamps = false;

    public function entregaelementoprotecciondetalles()
	{
		return $this->hasMany('App\EntregaElementoProteccionDetalle','ElementoProteccion_idElementoProteccion');
	}

    
}