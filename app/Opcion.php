<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'opcion';
    protected $primaryKey = 'idOpcion';

    protected $fillable = ['ordenOpcion', 'nombreOpcion', 'iconoOpcion', 'rutaOpcion', 'Paquete_idPaquete'];

    public $timestamps = false;
}
