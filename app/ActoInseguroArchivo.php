<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActoInseguroArchivo extends Model
{
    protected $table = 'actoinseguroarchivo';
    protected $primaryKey = 'idActoInseguroArchivo';

    protected $fillable = ['ActoInseguro_idActoInseguro','rutaActoInseguroArchivo'];

    public $timestamps = false;

      public function ActoInseguro()
    {
        return $this->hasOne('App\ActoInseguro','idActoInseguro');
    }
}
