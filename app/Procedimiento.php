<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    protected $table = 'procedimiento';
    protected $primaryKey = 'idProcedimiento';

    protected $fillable = ['Proceso_idProceso', 'fechaElaboracionProcedimiento', 
    						'objetivoProcedimiento', 'alcanceProcedimiento', 
    						'responsabilidadProcedimiento', 'Compania_idCompania'];

    public $timestamps = false;

    public function procedimientoDetalle()
    {
    	return $this->hasMany('App\ProcedimientoDetalle','Procedimiento_idProcedimiento');
    }
}
