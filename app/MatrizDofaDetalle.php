<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizDofaDetalle extends Model
{
    protected $table = 'matrizdofadetalle';
    protected $primaryKey = 'idMatrizDOFADetalle';

    protected $fillable = ['MatrizDOFA_idMatrizDOFA', 'tipoMatrizDOFADetalle', 'descripcionMatrizDOFADetalle', 'matrizRiesgoMatrizDOFADetalle'];

    public $timestamps = false;

    public function MatrizDofa()
    {
		return $this->hasOne('App\MatrizDofa','idMatrizDOFA');
    }
}
