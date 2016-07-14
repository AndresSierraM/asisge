<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConformacionGrupoApoyoJurado extends Model
{
    protected $table = 'conformaciongrupoapoyojurado';
    protected $primaryKey = 'idConformacionGrupoApoyoJurado';

    protected $fillable = ['ConformacionGrupoApoyo_idConformacionGrupoApoyo', 'Tercero_idJurado', 'firmaActaConformacionGrupoApoyoTercero'];

    public $timestamps = false;

    public function conformacionGrupoApoyo()
    {
		return $this->hasOne('App\ConformacionGrupoApoyo','idConformacionGrupoApoyo');
    }
}
