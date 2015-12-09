<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConformacionGrupoApoyo extends Model
{
    protected $table = 'conformaciongrupoapoyo';
    protected $primaryKey = 'idConformacionGrupoApoyo';

    protected $fillable = ['GrupoApoyo_idGrupoApoyo','nombreConformacionGrupoApoyo','fechaConformacionGrupoApoyo','fechaConvocatoriaConformacionGrupoApoyo','Tercero_idRepresentante','fechaVotacionConformacionGrupoApoyo','Tercero_idGerente','fechaActaConformacionGrupoApoyo','horaActaConformacionGrupoApoyo','fechaInicioConformacionGrupoApoyo','fechaFinConformacionGrupoApoyo','fechaConstitucionConformacionGrupoApoyo','Tercero_idPresidente','Tercero_idSecretario'];

    public $timestamps = false;

    public function conformacionGrupoApoyoComites()
    {
    	return $this->hasMany('App\ConformacionGrupoApoyoComite','ConformacionGrupoApoyo_idConformacionGrupoApoyo');
    }

    public function conformacionGrupoApoyoJurados()
    {
    	return $this->hasMany('App\ConformacionGrupoApoyoJurado','ConformacionGrupoApoyo_idConformacionGrupoApoyo');
    }

    public function conformacionGrupoApoyoResultados()
    {
    	return $this->hasMany('App\ConformacionGrupoApoyoResultado','ConformacionGrupoApoyo_idConformacionGrupoApoyo');
    }
}
