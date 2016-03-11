<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntasListaChequeo extends Model
{
    protected $table = 'preguntalistachequeo';
    protected $primaryKey = 'idPreguntaListaChequeo';

    protected $fillable = ['ordenPreguntaListaChequeo', 'descripcionPreguntaListaChequeo', 'Compania_idCompania'];

    public $timestamps = false;

}
