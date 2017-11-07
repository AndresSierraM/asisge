<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualGestion extends Model
{
    protected $table = 'manualgestion';
    protected $primaryKey = 'idManualGestion';

    protected $fillable = ['codigoManualGestion','nombreManualGestion','fechaManualGestion', 'Tercero_idEmpleador','firmaEmpleadorManualGestion','generalidadesManualGestion','misionManualGestion','visionManualGestion','valoresManualGestion','politicasManualGestion','principiosManualGestion','metasManualGestion','objetivosManualGestion','objetivoCalidadManualGestion','alcanceManualGestion','exclusionesManualGestion','Compania_idCompania'];

    public $timestamps = false;

    public function ManualGestionParte()
    {
		return $this->hasMany('App\ManualGestionParte','ManualGestion_idManualGestion');
    }
    public function ManualGestionProceso()
    {
        return $this->hasMany('App\ManualGestionProceso','ManualGestion_idManualGestion');
    }
    public function ManualGestionEstructura()
    {
        return $this->hasMany('App\ManualGestionEstructura','ManualGestion_idManualGestion');
    }
    public function ManualGestionAdjunto()
    {
        return $this->hasMany('App\ManualGestionAdjunto','ManualGestion_idManualGestion');
    }
}
