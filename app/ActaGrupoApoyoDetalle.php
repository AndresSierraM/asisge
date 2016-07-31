<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaGrupoApoyoDetalle extends Model
{
    protected $table = 'actagrupoapoyodetalle';
    protected $primaryKey = 'idActaGrupoApoyoDetalle';

    protected $fillable = ['ActaGrupoApoyo_idActaGrupoApoyo', 'actividadGrupoApoyoDetalle', 
                            'Tercero_idResponsableDetalle', 'fechaPlaneadaActaGrupoApoyoDetalle',
                            'Documento_idDocumento', 'recursoPlaneadoActaGrupoApoyoDetalle',
                            'recursoEjecutadoActaGrupoApoyoDetalle', 'fechaEjecucionGrupoApoyoDetalle',
                            'observacionGrupoApoyoDetalle'];

    public $timestamps = false;

    public function actagrupoapoyo()
    {
		return $this->hasOne('App\ActaGrupoApoyo','idActaGrupoApoyo');
    }
}
