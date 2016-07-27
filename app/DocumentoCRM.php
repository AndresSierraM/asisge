<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoCRM extends Model
{
    protected $table = 'documentocrm';
    protected $primaryKey = 'idDocumentoCRM';

    protected $fillable = ['codigoDocumentoCRM', 'nombreDocumentoCRM', 'tipoDocumentoCRM', 'numeracionDocumentoCRM', 'longitudDocumentoCRM', 'desdeDocumentoCRM', 'hastaDocumentoCRM', 'actualDocumentoCRM', 'Compania_idCompania', 'GrupoEstado_idGrupoEstado'];

    public $timestamps = false;

    public function documentocrmcampo()
    {
    	return $this->hasMany('App\DocumentoCRMCampo','DocumentoCRM_idDocumentoCRM');
    }

}