<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilCargo extends Model
{
    protected $table ='perfilcargo'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idPerfilCargo'; //camello
	
	protected $fillable = ['tipoPerfilCargo', 'nombrePerfilCargo', 'observacionPerfilCargo'];

	public $timestamps = false;
}



