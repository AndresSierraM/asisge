<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizLegalActualizacion extends Model
{
    protected $table = 'matrizlegalactualizacion';
    protected $primaryKey = 'idMatrizLegalActualizacion';

    protected $fillable = ['fechaMatrizLegalActualizacion','MatrizLegal_idMatrizLegal'];

    public $timestamps = false;

}
