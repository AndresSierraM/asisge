<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualGestionEstructura extends Model
{
    protected $table = 'manualgestionestructura';
    protected $primaryKey = 'idManualGestionEstructura';

    protected $fillable = ['ManualGestion_idManualGestion','rutaManualGestionEstructura'];

    public $timestamps = false;

     public function ManualGestion()
    {
		return $this->hasOne('App\ManualGestion','idManualGestion');
    }

    
}
