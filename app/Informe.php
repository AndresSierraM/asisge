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

  
    public function InformeRol() 
	{
		return $this->hasMany('App\InformeRol','Informe_idInforme');
	}

    public function InformeCompania() 
	{
		return $this->hasMany('App\InformeCompania','Informe_idInforme');
	}
}