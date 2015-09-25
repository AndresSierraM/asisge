<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizLegalDetalle extends Model
{
    protected $table = 'matrizlegaldetalle';
    protected $primaryKey = 'idMatrizLegalDetalle';

    protected $fillable = ['MatrizLegal_idMatrizLegal', 'TipoNormaLegal_idTipoNormaLegal', 'articuloAplicableMatrizLegalDetalle', 'ExpideNormaLegal_idExpideNormaLegal', 'exigenciaMatrizLegalDetalle', 'fuenteMatrizLegalDetalle', 'medioMatrizLegalDetalle', 'personaMatrizLegalDetalle', 'herramientaSeguimientoMatrizLegalDetalle', 'cumpleMatrizLegalDetalle', 'fechaVerificacionMatrizLegalDetalle', 'accionEvidenciaMatrizLegalDetalle', 'controlAImplementarMatrizLegalDetalle'];

    public $timestamps = false;

    public function matrizLegal()
    {
		return $this->hasOne('App\MatrizLegal','idMatrizLegal');
    }
}
