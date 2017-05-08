<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaTecnicaImagen extends Model
{
    protected $table = 'fichatecnicaimagen';
    protected $primaryKey = 'idFichaTecnicaImagen';

    protected $fillable = ['FichaTecnica_idFichaTecnica', 'tituloFichaTecnicaImagen', 'rutaFichaTecnicaImagen'];

    public $timestamps = false;

   
}