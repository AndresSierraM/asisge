<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConformacionGrupoApoyoResultado extends Model
{
    protected $table = 'conformaciongrupoapoyoresultado';
    protected $primaryKey = 'idConformacionGrupoApoyoResultado';

    protected $fillable = ['ConformacionGrupoApoyo_idConformacionGrupoApoyo', 'Tercero_idCandidato','votosConformacionGrupoApoyoResultado'];

    public $timestamps = false;

    public function conformacionGrupoApoyo()
    {
		return $this->hasOne('App\ConformacionGrupoApoyo','idConformacionGrupoApoyo');
    }
}
