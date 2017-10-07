<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeFiltro extends Model
{
    protected $table = 'informefiltro';
    protected $primaryKey = 'idInformeFiltro';

    protected $fillable = [ 'Informe_idInforme', 
                            'agrupadorInicialInformeFiltro', 
                            'campoInformeFiltro', 
                            'operadorInformeFiltro', 
                            'valorInformeFiltro', 
                            'agrupadorFinalInformeFiltro', 
                            'conectorInformeFiltro' 
                            ];

    public $timestamps = false;
}