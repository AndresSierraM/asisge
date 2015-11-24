<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerceroExamenMedico extends Model
{
    protected $table = 'terceroexamenmedico';
    protected $primaryKey = 'idTerceroExamenMedico';

    protected $fillable = ['Tercero_idTercero', 'ListaGeneral_idExamenMedico', 'ingresoTerceroExamenMedico', 'retiroTerceroExamenMedico', 'periodicoTerceroExamenMedico', 'FrecuenciaMedicion_idFrecuenciaMedicion'];

    public $timestamps = false;

    public function tercero()
    {
		return $this->hasOne('App\Tercero','idTercero');
    }
}
