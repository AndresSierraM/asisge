<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoApoyo extends Model
{
    protected $table = 'grupoapoyo';
    protected $primaryKey = 'idGrupoApoyo';

    protected $fillable = ['codigoGrupoApoyo', 'nombreGrupoApoyo','FrecuenciaMedicion_idFrecuenciaMedicion','fechaConformacionGrupoApoyo','fechaVencimientoGrupoApoyo','Compania_idCompania'];

    public $timestamps = false;

    // Campos quitados del Fillable , 'convocatoriaVotacionGrupoApoyo', 'actaEscrutinioGrupoApoyo','actaConstitucionGrupoApoyo',
     public function GrupoApoyoPermiso()
	{
		return $this->hasMany('App\GrupoApoyoPermiso','GrupoApoyo_idGrupoApoyo');
	}

}
