<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeColumna extends Model
{
    protected $table = 'informecolumna';
    protected $primaryKey = 'idInformeColumna';

    protected $fillable = ['Informe_idInforme', 
                            'secuenciaInformeColumna',
                            'campoInformeColumna', 
                            'ordenInformeColumna', 
                            'grupoInformeColumna', 
                            'ocultoInformeColumna', 
                            'tituloInformeColumna', 
                            'alineacionHInformeColumna', 
                            'alineacionVInformeColumna', 
                            'caracterRellenoInformeColumna', 
                            'alineacionRellenoInformeColumna', 
                            'calculoInformeColumna', 
                            'formatoInformeColumna', 
                            'longitudInformeColumna', 
                            'decimalesInformeColumna'  
                            ];

    public $timestamps = false;
}