<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConformacionGrupoApoyoInscrito extends Model
{
    protected $table = 'conformaciongrupoapoyoinscrito';
    protected $primaryKey = 'idConformacionGrupoApoyoInscrito';

    protected $fillable = ['ConformacionGrupoApoyo_idConformacionGrupoApoyo', 'Tercero_idInscrito'];

    public $timestamps = false;

    public function conformacionGrupoApoyo()
    {
		return $this->hasOne('App\ConformacionGrupoApoyo','idConformacionGrupoApoyo');
    }
}
