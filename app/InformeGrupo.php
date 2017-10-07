<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeGrupo extends Model
{
    protected $table = 'informegrupo';
    protected $primaryKey = 'idInformeGrupo';

    protected $fillable = ['Informe_idInforme', 
                            'campoInformeGrupo', 
                            'tituloEncabezadoInformeGrupo', 
                            'tituloPieInformeGrupo', 
                            'espaciadoInformeGrupo' 
                            ];

    public $timestamps = false;
}