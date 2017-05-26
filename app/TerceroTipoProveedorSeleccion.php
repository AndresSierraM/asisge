<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerceroTipoProveedorSeleccion extends Model
{
    protected $table = 'tercerotipoproveedorseleccion';
    protected $primaryKey = 'idTerceroTipoProveedorSeleccion';

    protected $fillable = ['cumpleTerceroTipoProveedorSeleccion', 'TipoProveedorSeleccion_idTipoProveedorSeleccion','Tercero_idTercero'];

    public $timestamps = false;

    public function tipoproveedorseleccion()
    {
		return $this->hasOne('App\TipoProveedorSeleccion','idTipoProveedorSeleccion');
    }

    public function tercero()
    {
		return $this->hasOne('App\Tercero','idTercero');
    }
}
