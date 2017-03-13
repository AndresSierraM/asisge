<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    protected $table = 'centrocosto';
    protected $primaryKey = 'idCentroCosto';

    protected $fillable = ['codigoCentroCosto', 'nombreCentroCosto','Compania_idCompania'];

    public $timestamps = false;


}



  

