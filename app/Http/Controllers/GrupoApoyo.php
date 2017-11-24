<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoApoyo extends Model
{
    protected $table = 'grupoapoyo';
    protected $primaryKey = 'idGrupoApoyo';

    protected $fillable = ['codigoGrupoApoyo', 'nombreGrupoApoyo', 'convocatoriaVotacionGrupoApoyo', 'actaEscrutinioGrupoApoyo','actaConstitucionGrupoApoyo', 'FrecuenciaMedicion_idFrecuenciaMedicion','Compania_idCompania'];

    public $timestamps = false;

}
