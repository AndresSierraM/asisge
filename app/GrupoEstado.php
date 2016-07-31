<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoEstado extends Model
{
    protected $table = 'grupoestado';
    protected $primaryKey = 'idGrupoEstado';

    protected $fillable = ['codigoGrupoEstado','nombreGrupoEstado'];

    public $timestamps = false;

    public function estadoCRM()
    {
		return $this->hasMany('App\EstadoCRM','GrupoEstado_idGrupoEstado');
    }

    
}
