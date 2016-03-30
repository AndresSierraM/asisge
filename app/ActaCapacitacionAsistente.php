<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaCapacitacionAsistente extends Model
{
	protected $table = 'actacapacitacionasistente';
    protected $primaryKey = 'idActaCapacitacionAsistente';

    protected $fillable = ['ActaCapacitacion_idActaCapacitacion', 'Tercero_idAsistente', 'firmaActaCapacitacionAsistente'];

    public $timestamps = false;

    function actaCapacitacion()
    {
		return $this->hasOne('App\ActaCapacitacion','idActaCapacitacion');
    }
}
