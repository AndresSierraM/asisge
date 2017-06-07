<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedimientoArchivo extends Model
{
    protected $table = 'procedimientoarchivo';
    protected $primaryKey = 'idProcedimientoArchivo';

    protected $fillable = ['rutaProcedimientoArchivo','Procedimiento_idProcedimiento'];

    public $timestamps = false;

    
}
