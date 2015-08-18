<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerceroContacto extends Model
{
    protected $table = 'tercerocontacto';
    protected $primaryKey = 'idTerceroContacto';

    protected $fillable = ['nombreTerceroContacto','cargoTerceroContacto','telefonoTerceroContacto','movilTerceroContacto','correoElectronicoTerceroContacto','Tercero_idTercero'];

    public $timestamps = false;

    public function tercero()
    {
		return $this->hasOne('App\Tercero','idTercero');
    }
}
