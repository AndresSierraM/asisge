<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class CuadroMando extends Model
{
    protected $table = 'cuadromando';
    protected $primaryKey = 'idCuadroMando';
    protected $fillable = ['numeroCuadroMando','CompaniaObjetivo_idCompaniaObjetivo', 'Compania_idCompania', 
			    'Proceso_idProceso','objetivoEspecificoCuadroMando','indicadorCuadroMando',
                'definicionIndicadorCuadroMando', 'formulaCuadroMando', 'operadorMetaCuadroMando',
                'valorMetaCuadroMando','tipoMetaCuadroMando', 'FrecuenciaMedicion_idFrecuenciaMedicion',
                'visualizacionCuadroMando', 'Tercero_idResponsable'];
                
    public $timestamps = false;

    public function companiaobjetivo()
    {
        return $this->hasOne('App\CompaniaObjetivo','idCompaniaObjetivo');
    }

    public function proceso()
    {
        return $this->hasOne('App\Proceso','idProceso');
    }

    public function frecuenciamedicion()
    {
        return $this->hasOne('App\FrecuenciaMedicion','idFrecuenciaMedicion');
    }

    public function tercero()
    {
        return $this->hasOne('App\Tercero','idTercero');
    }

}