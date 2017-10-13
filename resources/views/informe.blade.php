
 {!!Html::script('js/informe.js'); !!} 

@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Diseñador de Informes</center></h3>@stop

<?php 
    $formatoImpresion = ['Formato 1'=>'Formato 1','Formato 2'=>'Formato 2','Formato 3'=>'Formato 3'];
    //$informegrupo = ['Compras'=>'Compras','Ventas'=>'Ventas','Ajustes'=>'Ajustes'];
?>
@section('content')
	@include('alerts.request')
	@if(isset($informe))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($informe,['route'=>['informe.destroy',$informe->idInforme],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($informe,['route'=>['informe.update',$informe->idInforme],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'informe.store','method'=>'POST'])!!}
	@endif


    <script>
        // capturamos los datos de campos enviados desde el controller y los guardamos en una variable de JS
        var informecolumna = '<?php echo (isset($informecolumna) ? json_encode($informecolumna) : "");?>';
        informecolumna = (informecolumna != '' ? JSON.parse(informecolumna) : '');
        
        alineacionH =  [['I','C', 'D'] , ['Izquierda', 'Centro', 'Derecha']];
        alineacionV =  [['S','C', 'I'] , ['Superior', 'Centro', 'Inferior']];
        alineacionR =  [['I', 'D'] , ['Izquierda', 'Derecha']];

        var valorColumna = ['','','','','','','','','','','','','',''];

        
       $(document).ready(function(){

		    vista = "<?php echo @$informe->vistaInforme; ?>";
		    if($("#SistemaInformacion_idSistemaInformacion").val() !== '')
			    llamarVistas($("#SistemaInformacion_idSistemaInformacion").val(), vista);

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

            columnas.clase    = ['','','','','','','','','','','','','',''];
            columnas.sololectura = [true,true,false,false,false,false,false,false,false,false,false,false,false,false];  
            columnas.funciones = ['','','','','','','','','','','','','',''];
            columnas.completar = ['off','off','off','off','off','off','off','off','off','off','off','off','off','off'];
            columnas.opciones = ['','','','','','',alineacionH, alineacionV,'', alineacionR,'','','',''];

            for(var j=0, k = informecolumna.length; j < k; j++)
            {
                columnas.agregarCampos(JSON.stringify(informecolumna[j]),'L'); 
            }

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
                        {!!Form::select('CategoriaInforme_idCategoriaInforme',$categoriainforme, null,["class" => "chosen-select form-control","placeholder"=>"Seleccione Categoría"])!!}
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
                        {!!Form::text('nombreInforme',null,['class'=>'form-control','placeholder'=>'Ingresa el Nombre del Informe'])!!}
                        {!!Form::hidden('idInforme', null, array('id' => 'idInforme')) !!}
                        {!!Form::hidden('eliminarInformeColumna', null, array('id' => 'eliminarInformeColumna')) !!}
                        {!!Form::hidden('eliminarInformeGrupo', null, array('id' => 'eliminarInformeGrupo')) !!}
                        {!!Form::hidden('eliminarInformeFiltro', null, array('id' => 'eliminarInformeFiltro')) !!}

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
                        <a data-toggle="collapse" data-parent="#accordion" href="#columnas">
                            Columnas del Informe
                        </a>
                    </h4>
                </div>
                <div id="columnas" class="panel-collapse collapse in">
                    <div class="panel-body">

                        <div class="form-group" >
                            {!! Form::label('SistemaInformacion_idSistemaInformacion', 'Seleccione el Sistema', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    {!!Form::select('SistemaInformacion_idSistemaInformacion',$sistemainformacion, null,["class" => "chosen-select form-control", 'onchange'=>'llamarVistas(this.value, vista);', "placeholder"=>"Seleccione Sistema"])!!}
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
                                    {!!Form::select('vistaInforme',[''=>''], null,["id" => "vistaInforme", "class" => "chosen-select form-control","placeholder"=>"Seleccione la Consulta"])!!}
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group" id='test'>
                            <div class="col-sm-12">
                            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                <div style="overflow:auto; height:350px;">
                                    <div style="width: 1500px; display: inline-block;">
                                        <div class="col-md-1" style="width:40px; height: 35px; cursor:pointer;" 
                                        onclick="abrirModalCampos('iframeCampos', 'http://'+location.host+'/informecampo?basedatos='+$('#SistemaInformacion_idSistemaInformacion').val()+'&tabla='+$('#vistaInforme').val());">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </div>
                                        <div class="col-md-1" style="width: 200px; height: 35px;" >Campo</div>
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
                                        <div id="contenedor_columnas">
                                        </div>
                                    </div>
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#grupos">
                            Agrupaciones de datos
                        </a>
                    </h4>
                </div>
                <div id="grupos" class="panel-collapse collapse">
                    <div class="panel-body">
                        
                        <div class="form-group" id='test'>
                            <div class="col-sm-12">
                            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                <div style="overflow:auto; height:350px;">
                                <div style="width: 100%; display: inline-block;">
                                    <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" 
                                        onclick="abrirModalCampos('iframeCampos', 'http://'+location.host+'/informecampo?basedatos=sisoft&tabla=movimientocrm');">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1" style="width: 500px;" >Campo</div>
                                    <div class="col-md-1" style="width: 100px;" >Título Encabezado</div>
                                    <div class="col-md-1" style="width: 100px;" >Título Totales</div>
                                    <div class="col-md-1" style="width: 100px;" >Espaciado</div>
                                    <div id="contenedor_grupos">
                                    </div>
                                </div>
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#filtros">
                            Condiciones de Filtro
                        </a>
                    </h4>
                </div>
                <div id="filtros" class="panel-collapse collapse">
                    <div class="panel-body">

                        <div class="form-group" id='test'>
                            <div class="col-sm-12">
                            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                <div style="overflow:auto; height:350px;">
                                <div style="width: 100%; display: inline-block;">
                                    <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" 
                                        onclick="abrirModalCampos('Encabezado','iframeConceptos', 'http://'+location.host+'/gen_campogridselect?form=Inv_DocumentoInventarioForm&tipo=Encabezado');">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1" style="width: 500px;" >Grupo</div>
                                    <div class="col-md-1" style="width: 100px;" >Campo</div>
                                    <div class="col-md-1" style="width: 100px;" >Operador</div>
                                    <div class="col-md-1" style="width: 100px;" >Valor</div>
                                    <div class="col-md-1" style="width: 100px;" >Grupo</div>
                                    <div class="col-md-1" style="width: 100px;" >Conector</div>
                                    <div id="contenedor_filtros">
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
                {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
            @endif
        @else
            {!!Form::submit('Adicionar',["class"=>"btn btn-success"])!!}
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
