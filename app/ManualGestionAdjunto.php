<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualGestionAdjunto extends Model
{
    protected $table = 'manualgestionadjunto';
    protected $primaryKey = 'idManualGestionAdjunto';

    protected $fillable = ['ManualGestion_idManualGestion','rutaManualGestionAdjunto'];

    public $timestamps = false;

     public function ManualGestion()
    {
		return $this->hasOne('App\ManualGestion','idManualGestion');
    }

    
}
