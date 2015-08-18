<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerceroProducto extends Model
{
    protected $table = 'terceroproducto';
    protected $primaryKey = 'idTerceroProducto';

    protected $fillable = ['codigoTerceroProducto','nombreTerceroProducto','Tercero_idTercero'];

    public $timestamps = false;

    public function tercero()
    {
		return $this->hasOne('App\Tercero','idTercero');
    }
}
