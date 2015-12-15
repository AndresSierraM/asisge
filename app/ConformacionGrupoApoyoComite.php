<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConformacionGrupoApoyoComite extends Model
{
    protected $table = 'conformaciongrupoapoyocomite';
    protected $primaryKey = 'idConformacionGrupoApoyoComite';

    protected $fillable = ['ConformacionGrupoApoyo_idConformacionGrupoApoyo', 'nombradoPorConformacionGrupoApoyoComite','Tercero_idPrincipal','Tercero_idSuplente'];

    public $timestamps = false;

    public function conformacionGrupoApoyo()
    {
		return $this->hasOne('App\ConformacionGrupoApoyo','idConformacionGrupoApoyo');
    }
}
