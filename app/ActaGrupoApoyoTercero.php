<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaGrupoApoyoTercero extends Model
{
    protected $table = 'actagrupoapoyotercero';
    protected $primaryKey = 'idActaGrupoApoyoTercero';

    protected $fillable = [
					   'Tercero_idParticipante', 'ActaGrupoApoyo_idActaGrupoApoyo'
					    ];

    public $timestamps = false;

    public function actaGrupoApoyo()
    {
    	return $this->hasOne('App\ActaGrupoApoyo','ActaGrupoApoyo_idActaGrupoApoyo');
    }

}