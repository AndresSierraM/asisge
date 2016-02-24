<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaCapacitacionTema extends Model
{
	protected $table = 'actacapacitaciontema';
    protected $primaryKey = 'idActaCapacitacionTema';

    protected $fillable = ['ActaCapacitacion_idActaCapacitacion', 'Tercero_idAsistente'];

    public $timestamps = false;

    function actaCapacitacion()
    {
		return $this->hasOne('App\ActaCapacitacion','idActaCapacitacion');
    }
}
