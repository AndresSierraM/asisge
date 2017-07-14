<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoOperacion extends Model
{
    protected $table = 'ordentrabajooperacion';
    protected $primaryKey = 'idOrdenTrabajoOperacion';

    protected $fillable = ['OrdenTrabajo_idOrdenTrabajo', 'ordenOrdenTrabajoOperacion', 'nombreOrdenTrabajoOperacion', 'samOrdenTrabajoOperacion'];

    public $timestamps = false;

    
}