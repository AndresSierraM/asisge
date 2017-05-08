<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaCapacitacionArchivo extends Model
{
    protected $table = 'actacapacitacionarchivo';
    protected $primaryKey = 'idActaCapacitacionArchivo';

    protected $fillable = ['rutaActaCapacitacionArchivo','ActaCapacitacion_idActaCapacitacion'];

    public $timestamps = false;

    
}
