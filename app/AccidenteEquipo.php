<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccidenteEquipo extends Model
{
    protected $table = 'accidenteequipo';
    protected $primaryKey = 'idAccidenteEquipo';

    protected $fillable = [
					    'Accidente_idAccidente', 
					    'Tercero_idInvestigador'
					    ];

    public $timestamps = false;

    public function accidente()
    {
    	return $this->hasMany('App\Accidente','idAccidente');
    }
}