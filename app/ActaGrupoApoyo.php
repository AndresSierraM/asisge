<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaGrupoApoyo extends Model
{
    protected $table = 'actagrupoapoyo';
    protected $primaryKey = 'idActaGrupoApoyo';

    protected $fillable = [
                        'GrupoApoyo_idGrupoApoyo', 'fechaActaGrupoApoyo', 'horaInicioActaGrupoApoyo', 'horaFinActaGrupoApoyo', 'observacionActaGrupoApoyo', 'Compania_idCompania'
                        ];

    public $timestamps = false;

    public function actaGrupoApoyoTema()
    {
        return $this->hasMany('App\ActaGrupoApoyoTema','ActaGrupoApoyo_idActaGrupoApoyo');
    }
    public function actaGrupoApoyoTercero()
    {
        return $this->hasMany('App\ActaGrupoApoyoTercero','ActaGrupoApoyo_idActaGrupoApoyo');
    }

    public function actaGrupoApoyoDetalle()
    {
        return $this->hasMany('App\ActaGrupoApoyoDetalle','ActaGrupoApoyo_idActaGrupoApoyo');
    }

     public function ActaGrupoApoyoArchivo()
    {
        return $this->hasMany('App\ActaGrupoApoyoArchivo','ActaGrupoApoyo_idActaGrupoApoyo');
    }

}