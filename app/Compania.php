<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    protected $table = 'compania';
    protected $primaryKey = 'idCompania';

    protected $fillable = ['codigoCompania', 'nombreCompania'];

    public $timestamps = false;

    public function companiaobjetivos(){
		return $this->hasMany('App\CompaniaObjetivo','Compania_idCompania');
    }
}
