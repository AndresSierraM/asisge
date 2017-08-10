<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizDofa extends Model
{
    protected $table = 'matrizdofa';
    protected $primaryKey = 'idMatrizDOFA';

    protected $fillable = ['fechaElaboracionMatrizDOFA','Tercero_idResponsable','Proceso_idProceso', 'Compania_idCompania'];

    public $timestamps = false;

    public function MatrizDofaDetalle()
    {
		return $this->hasMany('App\MatrizDofaDetalle','MatrizDOFA_idMatrizDOFA');
    }
}
