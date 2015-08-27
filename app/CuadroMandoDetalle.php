<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class CuadroMandoDetalle extends Model
{
    protected $table = 'cuadromandodetalle';
    protected $primaryKey = 'idCuadroMandoDetalle';
    protected $fillable = ['CuadroMando_idCuadroMando', 'CompaniaObjetivo_idCompaniaObjetivo', 
			    'Proceso_idProceso','objetivoEspecificoCuadroMandoDetalle','indicadorCuadroMandoDetalle',
    			'operadorMetaCuadroMandoDetalle','valorMetaCuadroMandoDetalle','tipoMetaCuadroMandoDetalle',
    			'FrecuenciaMedicion_idFrecuenciaMedicion','Tercero_idResponsable'];
    public $timestamps = false;
    
    public function cuadromando()
    {
    	return $this->hasOne('App\CuadroMando','idCuadroMando');
    }
}