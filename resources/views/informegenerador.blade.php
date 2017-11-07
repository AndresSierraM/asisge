
 {!!Html::script('js/informe.js'); !!} 

@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Generador de Informes</center></h3>@stop

@section('content')
    @include('alerts.request')
	
	{!!Form::open(['route'=>'informe.store','method'=>'POST', 'id'=>'frmInforme'])!!}
	

    <script>
        var informefiltro = '<?php echo (isset($informefiltro) ? json_encode($informefiltro) : "");?>';
        informefiltro = (informefiltro != '' ? JSON.parse(informefiltro) : '');

        
        //******************************
        // Listas de Filtros
        //******************************
        var parentesisAbre = [["", "(", "((", "(((", "(((("], ["", "(", "((", "(((", "(((("]];
        var parentesisCierra = [["", ")", "))", ")))", "))))"], ["", ")", "))", ")))", "))))"]];

        var operador = [["=", ">", ">=", "<", "<=", "!=", 
                        "like%", "%like", "%like%", "BETWEEN"],
                        ["Igual a", "Mayor que", "Mayor o igual", "Menor que", "Menor o igual que", "Diferente de", 
                        "Comienza con", "Termina con", "Contiene", "Desde, Hasta"]];
        var campos = [[],[]];
        var conector =  [["AND", "OR"], ["Y", "O"]];
        
        var valorColumna = ['','0','','','','','','','','','','','','',''];
        var valorGrupo = ['','','','',''];
        var valorfiltros = [0,'','','','','','AND'];

        
       $(document).ready(function(){

            //***************************************
            //
            // F I L T R O S   D E L   I N F O R M E
            //
            //***************************************

            filtros = new Atributos('filtros','contenedor_filtros','filtros_');

            filtros.altura = '35px';
            filtros.campoid = 'idInformeFiltro';
            filtros.campoEliminacion = 'eliminarInformeFiltro';

            filtros.campos   = [
                                    'idInformeFiltro', 
                                    'agrupadorInicialInformeFiltro', 
                                    'campoInformeFiltro', 
                                    'operadorInformeFiltro', 
                                    'valorInformeFiltro', 
                                    'agrupadorFinalInformeFiltro', 
                                    'conectorInformeFiltro' 
                                ];

            filtros.etiqueta = ['input', 
                                    'select', 
                                    'select',
                                    'select',
                                    'input',
                                    'select',
                                    'select'
                                    ];

            filtros.tipo     = ['hidden',
                                    '' ,
                                    '',
                                    '',
                                    'text',
                                    '',
                                    ''
                                    ];

            filtros.opciones = ['', 
                                    parentesisAbre,
                                    campos,
                                    operador,
                                    '',
                                    parentesisCierra,
                                    conector
                                    ];

            filtros.estilo   = ['', 
                                    'width: 100px;height:35px; display:inline-block;',
                                    'width: 280px;height:35px; display:inline-block;',
                                    'width: 160px;height:35px; display:inline-block;',
                                    'width: 190px;height:35px; display:inline-block;',
                                    'width: 100px;height:35px; display:inline-block;',
                                    'width: 100px;height:35px; display:inline-block;'
                                    ];

            filtros.clase    = ['',
                                    '',
                                    '',
                                    '',
                                    '',
                                    '',
                                    ''
                                    ];

            filtros.sololectura = [false,
                                        false,
                                        false,
                                        false,
                                        false,
                                        false,
                                        false
                                        ];

            for(var j=0, k = informefiltro.length; j < k; j++)
            {
                filtros.agregarCampos(JSON.stringify(informefiltro[j]),'L'); 
            }


        });
    </script>

    <div id='form-section'>
        <fieldset id="titulo-form-fieldset">

            <div class="form-group" >
                {!! Form::label('idInforme', 'Seleccione Informe', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        {!!Form::select('idInforme',$informe, null,["onchange"=>"cargarFiltros(this.value);", "class" => "chosen-select form-control required","placeholder"=>"Seleccione Informe"])!!}
                        <input type="hidden" id="token" value="{{csrf_token()}}"/>
                    </div>
                </div>
            </div>

            
        </fieldset>


        <div class="panel-group" id="accordion"> 
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                            Condiciones de Filtro
                    </h4>
                </div>
                    <div class="panel-body">

                        <div class="form-group" id='test'>
                            <div class="col-sm-12">
                            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                <div style="overflow:auto; height:350px;">
                                <div style="width: 100%; display: inline-block;">
                                    <div class="col-md-1" style="width:40px;height: 35px; cursor:pointer;" 
                                        onclick="filtros.agregarCampos(valorfiltros, 'A')">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1" style="width: 100px;height: 35px;">Agrupador</div>
                                    <div class="col-md-1" style="width: 280px;height: 35px;">Campo</div>
                                    <div class="col-md-1" style="width: 160px;height: 35px;">Operador</div>
                                    <div class="col-md-1" style="width: 190px;height: 35px;">Valor</div>
                                    <div class="col-md-1" style="width: 100px;height: 35px;">Agrupador</div>
                                    <div class="col-md-1" style="width: 100px;height: 35px;">Conector</div>
                                    
                                </div>
                                <div id="contenedor_filtros">
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>

                    </div>
            </div>

            
        </div> 

        {!!Form::button('Generar',["class"=>"btn btn-success", "onclick"=>'concatenarCondicion();'])!!}
        {!! Form::close() !!}
    </div>
@stop
