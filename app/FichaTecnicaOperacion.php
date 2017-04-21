<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaOperacion extends Model
{
    protected $table = 'fichatecnicaoperacion';
    protected $primaryKey = 'idFichaTecnicaOperacion';

    protected $fillable = ['FichaTecnica_idFichaTecnica', 'ordenFichaTecnicaOperacion', 'nombreFichaTecnicaOperacion', 'Proceso_idProceso', 'samFichaTecnicaOperacion', 'observacionFichaTecnicaOperacion'];

    public $timestamps = false;

   
}