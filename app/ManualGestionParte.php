<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualGestionParte extends Model
{
    protected $table = 'manualgestionparte';
    protected $primaryKey = 'idManualGestionParte';

    protected $fillable = ['ManualGestion_idManualGestion','interesadoManualGestionParte','necesidadManualGestionParte', 'cumplimientoManualGestionParte'];

    public $timestamps = false;

    public function ManualGestion()
    {
		return $this->hasOne('App\ManualGestion','idManualGestion');
    }
}
