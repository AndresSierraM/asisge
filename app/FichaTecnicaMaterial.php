<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaMaterial extends Model
{
    protected $table = 'fichatecnicamaterial';
    protected $primaryKey = 'idFichaTecnicaMaterial';

    protected $fillable = ['FichaTecnica_idFichaTecnica', 'nombreFichaTecnicaMaterial', 'Proceso_idProceso', 'consumoFichaTecnicaMaterial', 'observacionFichaTecnicaMaterial'];

    public $timestamps = false;

   
}