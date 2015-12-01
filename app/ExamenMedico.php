<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenMedico extends Model
{
    protected $table = 'examenmedico';
    protected $primaryKey = 'idExamenMedico';

    protected $fillable = ['Tercero_idTercero', 'fechaExamenMedico', 'tipoExamenMedico'];

    public $timestamps = false;

    public function examenMedicoDetalle()
    {
    	return $this->hasMany('App\ExamenMedicoDetalle','ExamenMedico_idExamenMedico');
    }
}
