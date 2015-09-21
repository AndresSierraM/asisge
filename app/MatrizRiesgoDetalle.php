<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizRiesgoDetalle extends Model
{
    protected $table = 'matrizriesgodetalle';
    protected $primaryKey = 'idMatrizRiesgoDetalle';

    protected $fillable = ['MatrizRiesgo_idMatrizRiesgo', 'Proceso_idProceso', 'rutinariaMatrizRiesgoDetalle', 'ClasificacionRiesgo_idClasificacionRiesgo', 'TipoRiesgo_idTipoRiesgo', 'TipoRiesgoDetalle_idTipoRiesgoDetalle', 'TipoRiesgoSalud_idTipoRiesgoSalud', 'vinculadosMatrizRiesgoDetalle', 'temporalesMatrizRiesgoDetalle', 'independientesMatrizRiesgoDetalle', 'totalExpuestosMatrizRiesgoDetalle', 'fuenteMatrizRiesgoDetalle', 'medioMatrizRiesgoDetalle', 'personaMatrizRiesgoDetalle', 'nivelDeficienciaMatrizRiesgoDetalle', 'nivelExposicionMatrizRiesgoDetalle', 'nivelProbabilidadMatrizRiesgoDetalle', 'nombreProbabilidadMatrizRiesgoDetalle', 'nivelConsecuenciaMatrizRiesgoDetalle', 'nivelRiesgoMatrizRiesgoDetalle', 'nombreRiesgoMatrizRiesgoDetalle', 'aceptacionRiesgoMatrizRiesgoDetalle', 'ListaGeneral_idEliminacionRiesgo', 'ListaGeneral_idSustitucionRiesgo', 'ListaGeneral_idControlAdministrativo', 'ListaGeneral_idElementoProteccion', 'imagenMatrizRiesgoDetalle', 'observacionMatrizRiesgoDetalle'];

    public $timestamps = false;

    public function matrizRiesgo()
    {
		return $this->hasOne('App\MatrizRiesgo','idMatrizRiesgo');
    }
}
