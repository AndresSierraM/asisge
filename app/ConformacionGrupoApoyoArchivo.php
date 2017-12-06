<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConformacionGrupoApoyoArchivo extends Model
{
    protected $table = 'conformaciongrupoapoyoarchivo';
    protected $primaryKey = 'idConformacionGrupoApoyoArchivo';

    protected $fillable = ['ConformacionGrupoApoyo_idConformacionGrupoApoyo','rutaConformacionGrupoApoyoArchivo'];

    public $timestamps = false;


 	public function conformacionGrupoApoyo()
    {
		return $this->hasOne('App\ConformacionGrupoApoyo','idConformacionGrupoApoyo');
    }

    
}
