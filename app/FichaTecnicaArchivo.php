<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaArchivo extends Model
{
    protected $table = 'fichatecnicaarchivo';
    protected $primaryKey = 'idFichaTecnicaArchivo';

    protected $fillable = ['FichaTecnica_idFichaTecnica', 'rutaFichaTecnicaArchivo'];

    public $timestamps = false;

   
}