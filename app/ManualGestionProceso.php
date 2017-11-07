<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualGestionProceso extends Model
{
    protected $table = 'manualgestionproceso';
    protected $primaryKey = 'idManualGestionProceso';

    protected $fillable = ['ManualGestion_idManualGestion','rutaManualGestionProceso'];

    public $timestamps = false;

     public function ManualGestion()
    {
		return $this->hasOne('App\ManualGestion','idManualGestion');
    }

    
}
