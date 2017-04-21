<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaProceso extends Model
{
    protected $table = 'fichatecnicaproceso';
    protected $primaryKey = 'idFichaTecnicaProceso';

    protected $fillable = ['FichaTecnica_idFichaTecnica', 'ordenFichaTecnicaProceso', 'Proceso_idProceso', 'observacionFichaTecnicaProceso'];

    public $timestamps = false;

   
}