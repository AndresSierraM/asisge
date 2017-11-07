
 {!!Html::script('js/informe.js'); !!} 

@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Diseñador de Informes</center></h3>@stop

@section('content')
	@include('alerts.request')
	@if(isset($informe))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($informe,['route'=>['informe.destroy',$informe->idInforme],'method'=>'DELETE', 'id'=>'frmInforme'])!!}
		@else
			{!!Form::model($informe,['route'=>['informe.update',$informe->idInforme],'method'=>'PUT', 'id'=>'frmInforme'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'informe.store','method'=>'POST', 'id'=>'frmInforme'])!!}
	@endif


    <script>
        // capturamos los datos de campos enviados desde el controller y los guardamos en una variable de JS
        var informecolumna = '<?php echo (isset($informecolumna) ? json_encode($informecolumna) : "");?>';
        informecolumna = (informecolumna != '' ? JSON.parse(informecolumna) : '');

        var informegrupo = '<?php echo (isset($informegrupo) ? json_encode($informegrupo) : "");?>';
        informegrupo = (informegrupo != '' ? JSON.parse(informegrupo) : '');
        
        var informefiltro = '<?php echo (isset($informefiltro) ? json_encode($informefiltro) : "");?>';
        informefiltro = (informefiltro != '' ? JSON.parse(informefiltro) : '');

        //******************************
        // Listas de Campos
        //******************************
        alineacionH =  [['I','C', 'D'] , ['Izquierda', 'Centro', 'Derecha']];
        alineacionV =  [['S','C', 'I'] , ['Superior', 'Centro', 'Inferior']];
        alineacionR =  [['I', 'D'] , ['Izquierda', 'Derecha']];
        funcionGrupo = ['onclick' , 'modificarGrupo(this.id);'];
        calculo = [['Ninguna','Suma','Promedio','Conteo'], ['Ninguna','Suma','Promedio','Conteo']];
        formato = [['Texto','NumeroSeparador','Numero','MonedaSeparador','Moneda','DMA','AMD','MDA','Hora','Porcentaje'],
                    ['Texto','Numero con Separador','Numero','Moneda con Separador','Moneda','Día-Mes-Año','Año-Mes-Día','Mes-Día-Año','Hora','Porcentaje']];
        
        //******************************
        // Listas de Filtros
        //******************************
        var parentesisAbre = [["", "(", "((", "(((", "(((("], ["", "(", "((", "(((", "(((("]];
        var parentesisCierra = [["", ")", "))", ")))", "))))"], ["", ")", "))", ")))", "))))"]];

        var operador = [["=", ">", ">=", "<", "<=", "!=", "like%", "%like", "%like%", "BETWEEN"],
                        ["Igual a", "Mayor que", "Mayor o igual", "Menor que", "Menor o igual que", "Diferente de", "Comienza con", "Termina con", "Contiene", "Desde, Hasta"]];
        var campos = [[],[]];
        var conector =  [["AND", "OR"], ["Y", "O"]];
        
        var valorColumna = ['','0','','','','','','','','','','','','',''];
        var valorGrupo = ['','','','',''];
        var valorfiltros = [0,'','','','','',''];

        
       $(document).ready(function(){

		    

            //***************************************
            //
            // C O L U M N A S   D E L   I N F O R M E
            //
            //***************************************
            columnas = new Atributos('columnas','contenedor_columnas','informecolumna');

            columnas.altura = '35px';
            columnas.campoid = 'idInformeColumna';
            columnas.campoEliminacion = 'eliminarInformeColumna';

            columnas.campos   = [
                                'idInformeColumna',
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

            columnas.etiqueta = [
                                'input',
                                'input',
                                'input',
                                'checkbox',
                                'checkbox',
                                'checkbox',
                                'input',
                                'select',
                                'select',
                                'input',
                                'select',
                                'select',
                                'select',
                                'input',
                                'input'
                                ];

            columnas.tipo = [
                                'hidden',
                                'text',
                                'text',
                                'checkbox',
                                'checkbox',
                                'checkbox',
                                'text',
                                '',
                                '',
                                'text',
                                '',
                                '',
                                '',
                                'text',
                                'text'
                                ];

            columnas.estilo = [
                                '',
                                'width: 70px; height: 35px; display:inline-block;',
                                'width: 200px; height: 35px; display:inline-block;',
                                'width: 70px; height: 35px; display:inline-block;',
                                'width: 70px; height: 35px; display:inline-block;',
                                'width: 70px; height: 35px; display:inline-block;',
                                'width: 200px; height: 35px; display:inline-block;',
                                'width: 100px; height: 35px; display:inline-block;',
                                'width: 100px; height: 35px; display:inline-block;',
                                'width: 80px; height: 35px; display:inline-block;',
                                'width: 150px; height: 35px; display:inline-block;',
                                'width: 150px; height: 35px; display:inline-block;',
                                'width: 150px; height: 35px; display:inline-block;',
                                'width: 60px; height: 35px; display:inline-block;',
                                'width: 60px; height: 35px; display:inline-block;',
                                ];

            columnas.clase    = ['','','','','','','','','','','','','','numerico','numerico'];
            columnas.sololectura = [true,false, true,false,false,false,false,false,false,false,false,false,false,false,false];  
            columnas.funciones = ['','','','', funcionGrupo,'','','','','','','','','',''];
            columnas.completar = ['off','off','off','off','off','off','off','off','off','off','off','off','off','off','off'];
            columnas.opciones = ['','','','','','','',alineacionH, alineacionV,'', alineacionR,calculo,formato,'',''];

            for(var j=0, k = informecolumna.length; j < k; j++)
            {
                columnas.agregarCampos(JSON.stringify(informecolumna[j]),'L'); 
            }


            //***************************************
            //
            // G R U P O S   D E L   I N F O R M E
            //
            //***************************************
            grupos = new Atributos('grupos','contenedor_grupos','informegrupo');

            grupos.altura = '35px';
            grupos.campoid = 'idInformeGrupo';
            grupos.botonEliminacion = false;
            grupos.campoEliminacion = 'eliminarInformeGrupo';

            grupos.campos   = [
                                 'idInformeGrupo', 
                                 'campoInformeGrupo', 
                                 'tituloEncabezadoInformeGrupo', 
                                 'tituloPieInformeGrupo', 
                                 'espaciadoInformeGrupo' 
                                ];

            grupos.etiqueta = [
                                'input',
                                'input',
                                'input',
                                'input',
                                'input'
                                ];

            grupos.tipo = [
                                'hidden',
                                'text',
                                'text',
                                'text',
                                'text'
                                ];

            grupos.estilo = [
                                '',
                                'width: 300px; height: 35px; display:inline-block;',
                                'width: 400px; height: 35px; display:inline-block;',
                                'width: 400px; height: 35px; display:inline-block;',
                                'width: 100px; height: 35px; display:inline-block;'
                                ];

            grupos.clase    = ['','','','','numerico'];
            grupos.sololectura = [true,true,false,false,false];  
            grupos.funciones = ['','','','',''];
            grupos.completar = ['off','off','off','off','off'];
            grupos.opciones = ['','','','','',''];

            for(var j=0, k = informegrupo.length; j < k; j++)
            {
                grupos.agregarCampos(JSON.stringify(informegrupo[j]),'L'); 
            }


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


            //***************************************
            //
            // R O L E S   D E L   I N F O R M E
            //
            //***************************************
            

            // rol = [JSON.parse(idRol),JSON.parse(nombreRol)];

            var informerol = '<?php echo (isset($informerol) ? json_encode($informerol) : "");?>';
            informerol = (informerol != '' ? JSON.parse(informerol) : '');
            var valorInformeRol = ['','',0,0,0,0,0,0,0,0];


            protRol = new Atributos('protRol','contenedor_permisos','permisos_');

            protRol.altura = '35px';
            protRol.campoid = 'idInformeRol';
            protRol.campoEliminacion = 'eliminarRol';

            protRol.campos   = ['idInformeRol','Rol_idRol','nombreRol'];
            protRol.etiqueta = ['input','input','input'];
            protRol.tipo     = ['hidden','hidden','text'];
            protRol.estilo   = ['','','width: 600px;height:35px'];
            protRol.clase    = ['','',''];
            protRol.sololectura = [true,true,true];
            
            for(var j=0, k = informerol.length; j < k; j++)
            {
                protRol.agregarCampos(JSON.stringify(informerol[j]),'L');
            }
                

        
            //***************************************
            //
            // C O M P A N I A S   D E L   I N F O R M E
            //
            //***************************************

            var informecompania = '<?php echo (isset($informecompania) ? json_encode($informecompania) : "");?>';
            informecompania = (informecompania != '' ? JSON.parse(informecompania) : '');
            var valorCompania = ['','', 0];


            protCompania = new Atributos('protCompania','contenedor_compania','compania_');

            protCompania.altura = '35px';
            protCompania.campoid = 'idInformeCompania';
            protCompania.campoEliminacion = 'eliminarCompania';

            protCompania.campos   = ['idInformeCompania', 'Compania_idCompania', 'nombreCompania'];
            protCompania.etiqueta = ['input', 'input', 'input'];
            protCompania.tipo     = ['hidden', 'hidden', 'text'];
            protCompania.estilo   = ['', '' ,'width: 800px;height:35px;'];
            protCompania.clase    = ['','', '', ''];
            protCompania.sololectura = [true,true,true];
            for(var j=0, k = informecompania.length; j < k; j++)
            {
                protCompania.agregarCampos(JSON.stringify(informecompania[j]),'L');
            }


            vista = "<?php echo @$informe->vistaInforme; ?>";
		    if($("#SistemaInformacion_idSistemaInformacion").val() !== '')
			    llamarVistas($("#SistemaInformacion_idSistemaInformacion").val(), vista);

        });
    </script>

    <div id='form-section'>
        <fieldset id="titulo-form-fieldset">

            <div class="form-group" >
                {!! Form::label('CategoriaInforme_idCategoriaInforme', 'Categoría', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        {!!Form::select('CategoriaInforme_idCategoriaInforme',$categoriainforme, null,["class" => "chosen-select form-control required","placeholder"=>"Seleccione Categoría"])!!}
                        <input type="hidden" id="token" value="{{csrf_token()}}"/>
                    </div>
                </div>
            </div>
            
            <div class="form-group" >
                {!!Form::label('nombreInforme', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-barcode"></i>
                        </span>
                        {!!Form::text('nombreInforme',null,['class'=>'form-control required','placeholder'=>'Ingresa el Nombre del Informe'])!!}
                        {!!Form::hidden('idInforme', null, array('id' => 'idInforme')) !!}
                        {!!Form::hidden('eliminarInformeColumna', null, array('id' => 'eliminarInformeColumna')) !!}
                        {!!Form::hidden('eliminarInformeGrupo', null, array('id' => 'eliminarInformeGrupo')) !!}
                        {!!Form::hidden('eliminarInformeFiltro', null, array('id' => 'eliminarInformeFiltro')) !!}
                        {!!Form::hidden('eliminarRol', null, array('id' => 'eliminarRol')) !!}
                        {!!Form::hidden('eliminarCompania', null, array('id' => 'eliminarCompania')) !!}

                    </div>
                </div>
            </div>

            <div class="form-group" >
                {!!Form::label('descripcionInforme', 'Descripción', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-barcode"></i>
                        </span>
                        {!!Form::textarea('descripcionInforme',null,['class'=>'form-control','placeholder'=>'Ingresa la descripción del Informe'])!!}
                    </div>
                </div>
            </div>

            
        </fieldset>


        <div class="panel-group" id="accordion"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Columnas del Informe
                    </h4>
                </div>
                <div class="panel-body">

                    <div class="form-group" >
                        {!! Form::label('SistemaInformacion_idSistemaInformacion', 'Seleccione el Sistema', array('class' => 'col-sm-2 control-label')) !!}
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                {!!Form::select('SistemaInformacion_idSistemaInformacion',$sistemainformacion, null,
                                            ["class" => "chosen-select form-control", 
                                            'onchange'=>'limpiarMultiregistros(); llamarVistas(this.value, vista);', 
                                            "placeholder"=>"Seleccione Sistema"])!!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >
                        {!! Form::label('vistaInforme', 'Seleccione la Tabla o Vista', array('class' => 'col-sm-2 control-label')) !!}
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                {!!Form::select('vistaInforme',[''=>''], null,
                                            ["id" => "vistaInforme",
                                            "onchange"=>"limpiarMultiregistros(); llamarCampos(this.value);", 
                                            "class" => "chosen-select form-control",
                                            "placeholder"=>"Seleccione la Consulta"])!!}
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group" id='test'>
                        <div class="col-sm-12">
                        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                            <div style="overflow:auto; height:350px;">
                                <div style="width: 1600px; display: inline-block;">
                                    <div class="col-md-1" style="width:40px; height: 35px; cursor:pointer;" 
                                    onclick="abrirModalCampos('iframeCampos', 'http://'+location.host+'/informecampo?basedatos='+$('#SistemaInformacion_idSistemaInformacion').val()+'&tabla='+$('#vistaInforme').val());">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1" style="width: 70px; height: 35px;" >Secuencia</div>
                                    <div class="col-md-1" style="width: 200px; height: 35px;">Campo</div>
                                    <div class="col-md-1" style="width: 70px; height: 35px;" >Orden</div>
                                    <div class="col-md-1" style="width: 70px; height: 35px;" >Grupo</div>
                                    <div class="col-md-1" style="width: 70px; height: 35px;" >Oculto</div>
                                    <div class="col-md-1" style="width: 200px; height: 35px;" >Título</div>
                                    <div class="col-md-1" style="width: 100px; height: 35px;" >Horizontal</div>
                                    <div class="col-md-1" style="width: 100px; height: 35px;" >Vertical</div>
                                    <div class="col-md-1" style="width: 80px; height: 35px;" >Relleno</div>
                                    <div class="col-md-1" style="width: 150px; height: 35px;" >Alinea Relleno</div>
                                    <div class="col-md-1" style="width: 150px; height: 35px;" >Cálculo</div>
                                    <div class="col-md-1" style="width: 150px; height: 35px;" >Formato</div>
                                    <div class="col-md-1" style="width: 60px; height: 35px;" title="Longitud de caracteres">Long</div>
                                    <div class="col-md-1" style="width: 60px; height: 35px;" title="cantidad de decimales">Dec</div>
                                    
                                </div>
                                <div id="contenedor_columnas">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                            
                </div>
                
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                            Agrupaciones de datos
                    </h4>
                </div>
                    <div class="panel-body">
                        
                        <div class="form-group" id='test'>
                            <div class="col-sm-12">
                            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                <div style="overflow:auto; height:350px;">
                                <div style="width: 100%; display: inline-block;">
                                    
                                    <div class="col-md-1" style="width: 300px; height: 35px;" >Campo</div>
                                    <div class="col-md-1" style="width: 400px; height: 35px;" >Título Encabezado</div>
                                    <div class="col-md-1" style="width: 400px; height: 35px;" >Título Totales</div>
                                    <div class="col-md-1" style="width: 100px; height: 35px;" >Espaciado</div>
                                    
                                </div>
                                <div id="contenedor_grupos">
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>

                    </div>
            </div>
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

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                            Permisos
                    </h4>
                </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#permCompania">Compañías</a></li>
                          <li><a data-toggle="tab" href="#permRol">Roles</a></li>
                        </ul>

                        <div class="tab-content">
                          <div id="permCompania" class="tab-pane fade in active">
                            <div class="panel-body" id="permCompania">
                              <div class="form-group" id='test'>
                                <div class="col-sm-12">
                                  <div class="panel-body" >
                                    <div class="form-group" id='test'>
                                      <div class="col-sm-12">
                                        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                          <div class="col-md-1" style="width: 40px; cursor: pointer;" onclick="mostrarModalCompania()">
                                            <span class="glyphicon glyphicon-plus"></span>
                                          </div>
                                          <div class="col-md-1" style="width: 800px;">Compañía</div>
                                          <div id="contenedor_compania">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>  
                            </div>
                          </div>

                          <div id="permRol" class="tab-pane fade">
                            <div class="panel-body" >
                              <div class="form-group" id='test'>
                                <div class="col-sm-12">
                                  <div class="panel-body" >
                                    <div class="form-group" id='test'>
                                      <div class="col-sm-12">
                                        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                          <div class="col-md-1" style="width: 40px; cursor: pointer;" onclick="mostrarModalRol()">
                                          <span class="glyphicon glyphicon-plus"></span>
                                          </div>
                                          <div class="col-md-1" style="width: 600px;">Rol</div>
                                          <div id="contenedor_permisos">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>  
                            </div>
                          </div>  
                        </div>

                    </div>
            </div>
        </div> 

        @if(isset($informe))
            @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
                {!!Form::submit('Eliminar',["class"=>"btn btn-danger"])!!}
            @else
                {!!Form::submit('Modificar',["class"=>"btn btn-primary", "onclick"=>'validarFormulario(event);'])!!}
            @endif
        @else
            {!!Form::submit('Adicionar',["class"=>"btn btn-success", "onclick"=>'validarFormulario(event);'])!!}
        @endif
        {!! Form::close() !!}
    </div>
@stop

<div id="ModalCampos" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">
    {!!Form::hidden('txTipo', null, array('id' => 'txTipo')) !!}
    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Campos</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="iframeCampos" name="campos" src=""></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal de roles-->
<div id="ModalRoles" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:1000px;">

        <!-- Modal content-->
        <div style="" class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Selecci&oacute;n de Roles</h4>
        </div>
        <div class="modal-body">
            <iframe style="width:100%; height:500px; " id="rol" name="rol" src="{!! URL::to ('rolselect')!!}"> </iframe> 
        </div>
        </div>
    </div>
</div>

<!-- Modal de compañias -->
<div id="ModalCompanias" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:1000px;">

        <!-- Modal content-->
        <div style="" class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Selecci&oacute;n de Compañias</h4>
        </div>
        <div class="modal-body">
            <iframe style="width:100%; height:500px; " id="rol" name="rol" src="{!! URL::to ('companiaselect')!!}"></iframe> 
        </div>
        </div>
    </div>
</div>