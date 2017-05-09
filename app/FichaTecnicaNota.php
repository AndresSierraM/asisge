<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaNota extends Model
{
    protected $table = 'fichatecnicanota';
    protected $primaryKey = 'idFichaTecnicaNota';

    protected $fillable = ['FichaTecnica_idFichaTecnica', 'Users_idUsuario', 'fechaFichaTecnicaNota', 'observacionFichaTecnicaNota'];

    public $timestamps = false;

   
}