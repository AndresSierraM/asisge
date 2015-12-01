<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoExamenMedico extends Model
{
    protected $table = 'tipoexamenmedico';
    protected $primaryKey = 'idTipoExamenMedico';

    protected $fillable = ['codigoTipoExamenMedico', 'nombreTipoExamenMedico', 'limiteInferiorTipoExamenMedico', 'limiteSuperiorTipoExamenMedico', 'observacionTipoExamenMedico'];

    public $timestamps = false;

    public function terceroExamenMedico()
    {
		return $this->hasMany('App\TerceroExamenMedico','TipoExamenMedico_idTipoExamenMedico');
    }
}