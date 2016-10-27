<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenMedicoDetalle extends Model
{
    protected $table = 'examenmedicodetalle';
    protected $primaryKey = 'idExamenMedicoDetalle';

    protected $fillable = ['ExamenMedico_idExamenMedico','TipoExamenMedico_idTipoExamenMedico',
    						'resultadoExamenMedicoDetalle','fotoExamenMedicoDetalle','observacionExamenMedicoDetalle'];

    public $timestamps = false;

    public function examenmedico()
    {
		return $this->hasOne('App\ExamenMedico','idExamenMedico');
    }

    public function tipoexamenmedico()
    {
        return $this->hasOne('App\TipoExamenMedico','idTipoExamenMedico');
    }
}
