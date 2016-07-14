<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerceroArchivo extends Model
{
    protected $table = 'terceroarchivo';
    protected $primaryKey = 'idTerceroArchivo';

    protected $fillable = ['Tercero_idTercero', 'tituloTerceroArchivo', 'fechaTerceroArchivo', 'descripcionTerceroArchivo', 'rutaTerceroArchivo'];

    public $timestamps = false;

    public function tercero()
    {
		return $this->hasOne('App\Tercero','idTercero');
    }
}
