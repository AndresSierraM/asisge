<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    protected $table = 'procedimiento';
    protected $primaryKey = 'idProcedimiento';

    protected $fillable = ['Proceso_idProceso', 'nombreProcedimiento', 'fechaElaboracionProcedimiento', 
    						'objetivoProcedimiento', 'alcanceProcedimiento', 
    						'responsabilidadProcedimiento', 'generalidadProcedimiento', 'Compania_idCompania'];

    public $timestamps = false;

    public function procedimientoDetalle()
    {
    	return $this->hasMany('App\ProcedimientoDetalle','Procedimiento_idProcedimiento');
    }
    
    public function ProcedimientoArchivo()
    {
        return $this->hasMany('App\procedimientoarchivo','Procedimiento_idProcedimiento');
    }
}
