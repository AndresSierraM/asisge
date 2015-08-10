<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompaniaObjetivo extends Model
{
    protected $table = 'companiaobjetivo';
    protected $primaryKey = 'idCompaniaObjetivo';

    protected $fillable = ['nombreCompaniaObjetivo','Compania_idCompania'];

    public $timestamps = false;
}
