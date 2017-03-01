<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'idRol';

    protected $fillable = ['codigoRol', 'nombreRol','Compania_idCompania'];

    public $timestamps = false;

    public function rolOpcion()
    {
    	return $this->hasMany('App\RolOpcion','Rol_idRol');
    }
}
