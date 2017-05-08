<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaGrupoApoyoArchivo extends Model
{
    protected $table = 'actagrupoapoyoarchivo';
    protected $primaryKey = 'idActaGrupoApoyoArchivo';

    protected $fillable = ['rutaActaGrupoApoyoArchivo','ActaGrupoApoyo_idActaGrupoApoyo'];

    public $timestamps = false;

    
}
