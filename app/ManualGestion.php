<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualGestion extends Model
{
    protected $table = 'manualgestion';
    protected $primaryKey = 'idManualGestion';

    protected $fillable = ['codigoManualGestion','nombreManualGestion','fechaManualGestion', 'Tercero_idEmpleador','firmaEmpleadorManualGestion','generalidadesManualGestion','misionManualGestion','visionManualGestion','valoresManualGestion','politicasManualGestion','principiosManualGestion','metasManualGestion','objetivosManualGestion','objetivoCalidadManualGestion','alcanceManualGestion','exclusionesManualGestion','Compania_idCompania'];

    public $timestamps = false;

  //   public function PlanEmergenciaLimite()
  //   {
		// return $this->hasMany('App\PlanEmergenciaLimite','PlanEmergencia_idPlanEmergencia');
  //   }

}
