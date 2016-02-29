<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaGrupoApoyoTema extends Model
{
    protected $table = 'actagrupoapoyotema';
    protected $primaryKey = 'idActaGrupoApoyoTema';

    protected $fillable = [
					   'temaActaGrupoApoyoTema', 'desarrolloActaGrupoApoyoTema', 'Tercero_idResponsable', 'observacionActaGrupoApoyoTema', 'ActaGrupoApoyo_idActaGrupoApoyo'
					    ];

    public $timestamps = false;

    public function actaGrupoApoyo()
    {
    	return $this->hasOne('App\ActaGrupoApoyo','ActaGrupoApoyo_idActaGrupoApoyo');
    }

}