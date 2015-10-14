<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedimientoDetalle extends Model
{
    protected $table = 'procedimientodetalle';
    protected $primaryKey = 'idProcedimientoDetalle';

    protected $fillable = ['Procedimiento_idProcedimiento', 'actividadProcedimientoDetalle', 
                            'Tercero_idResponsable', 'Documento_idDocumento'];

    public $timestamps = false;

    public function procedimiento()
    {
		return $this->hasOne('App\Procedimiento','idProcedimiento');
    }
}
