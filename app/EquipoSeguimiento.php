<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoSeguimiento extends Model
{
    protected $table = 'equiposeguimiento';
    protected $primaryKey = 'idEquipoSeguimiento';

    protected $fillable = ['fechaEquipoSeguimiento','nombreEquipoSeguimiento','Tercero_idResponsable', 'Compania_idCompania'];

    public $timestamps = false;

    public function EquipoSeguimientoDetalle()
    {
		return $this->hasMany('App\EquipoSeguimientoDetalle','EquipoSeguimiento_idEquipoSeguimiento');
    }
}
