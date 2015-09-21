<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaGeneral extends Model
{
    protected $table = 'listageneral';
    protected $primaryKey = 'idListaGeneral';

    protected $fillable = ['tipoListaGeneral', 'codigoListaGeneral', 'nombreListaGeneral', 'observacionListaGeneral'];

    public $timestamps = false;
}
