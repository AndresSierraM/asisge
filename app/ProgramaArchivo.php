<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramaArchivo extends Model
{
    protected $table = 'programaarchivo';
    protected $primaryKey = 'idProgramaArchivo';

    protected $fillable = ['Programa_idPrograma','rutaProgramaArchivo'];

    public $timestamps = false;

     public function Programa()
    {
		return $this->hasOne('App\Programa','idPrograma');
    }

    
}
