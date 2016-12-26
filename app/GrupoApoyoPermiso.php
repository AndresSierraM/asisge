<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoApoyoPermiso extends Model
{
    protected $table = 'grupoapoyopermiso';
    protected $primaryKey = 'idGrupoApoyoPermiso';

    protected $fillable = ['GrupoApoyo_idGrupoApoyo', 
						    'Rol_idRol', 
						    'adicionarGrupoApoyoPermiso', 
						    'modificarGrupoApoyoPermiso',
						    'eliminarGrupoApoyoPermiso',
						    'consultarGrupoApoyoPermiso'
						  ];

    public $timestamps = false;

    public function GrupoApoyo()
	{
		return $this->hasOne('App\GrupoApoyo','idGrupoApoyo');
	}
}
