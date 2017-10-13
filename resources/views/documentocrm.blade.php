@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Documentos CRM</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/documentocrm.js')!!}

<script>

    var documentocrmcampo = '<?php echo (isset($documentocrm) ? json_encode($documentocrm->documentocrmcampo) : "");?>';
    documentocrmcampo = (documentocrmcampo != '' ? JSON.parse(documentocrmcampo) : '');

    var documentocrmbase = '<?php echo (isset($documentocrm) ? json_encode($documentocrm->documentocrmbase) : "");?>';
    documentocrmbase = (documentocrmbase != '' ? JSON.parse(documentocrmbase) : '');

    var documentocrmgrafico = '<?php echo (isset($documentocrm) ? json_encode($documentocrm->documentocrmgrafico) : "");?>';
    documentocrmgrafico = (documentocrmgrafico != '' ? JSON.parse(documentocrmgrafico) : '');

    // var documentocrmcompania = '<?php echo (isset($documentocrm) ? json_encode($documentocrm->documentocrmcompania) : "");?>';
    // documentocrmcompania = (documentocrmcompania != '' ? JSON.parse(documentocrmcompania) : '');

    var documentocrmrol = '<?php echo (isset($documentocrm) ? json_encode($documentocrm->documentocrmrol) : "");?>';
    documentocrmrol = (documentocrmrol != '' ? JSON.parse(documentocrmrol) : '');

    var idDocumentoCRMBase = '<?php echo isset($iddocumentocrmbase) ? $iddocumentocrmbase : 0;?>';
		var nombreDocumentoCRMBase = '<?php echo isset($nombredocumentocrmbase) ? $nombredocumentocrmbase : "";?>';
		
		var listaDocumentoBase = [JSON.parse(idDocumentoCRMBase),JSON.parse(nombreDocumentoCRMBase)];

    var valoresGrafico = [0,'','','',''];
    var valoresDocumento = [0,0];
    $(document).ready(function(){

      protCampos = new Atributos('protCampos','contenedor_protCampos','documentocrmcampo');

      protCampos.altura = '35px';
      protCampos.campoid = 'idDocumentoCRMCampo';
      protCampos.campoEliminacion = 'eliminarDocumentoCRMCampo';

      protCampos.campos   = [
      'idDocumentoCRMCampo',
      'CampoCRM_idCampoCRM',
      'descripcionCampoCRM',
      'mostrarGridDocumentoCRMCampo', 
      'mostrarVistaDocumentoCRMCampo', 
      'obligatorioDocumentoCRMCampo', 
      'solicitanteDocumentoCRMCampo', 
      'asesorDocumentoCRMCampo', 
      'aprobadorDocumentoCRMCampo'
      ];

      protCampos.etiqueta = [
      'input',
      'input',
      'input',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox'
      ];

      protCampos.tipo = [
      'hidden',
      'hidden',
      'text',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox'
      ];

      protCampos.estilo = [
      '',
      '',
      'width: 260px;height:35px;',
      'width: 100px;height:35px; display:inline-block;',
      'width: 100px;height:35px; display:inline-block;',
      'width: 100px;height:35px; display:inline-block;',
      'width: 100px;height:35px; display:inline-block;',
      'width: 100px;height:35px; display:inline-block;',
      'width: 100px;height:35px; display:inline-block;'
      ];

      protCampos.clase    = ['','','','','','','','',''];
      protCampos.sololectura = [true,true,true,false,false,false,false,false,false];  
      protCampos.funciones = ['','','','','','','','',''];
      protCampos.completar = ['off','off','off','off','off','off','off','off','off'];
      protCampos.opciones = ['','','','','','','','',''];

      for(var j=0, k = documentocrmcampo.length; j < k; j++)
      {
        protCampos.agregarCampos(JSON.stringify(documentocrmcampo[j]),'L');

        llenarDatosCampo($('#CampoCRM_idCampoCRM'+j).val(), j);
      }


      protDocumentos = new Atributos('protDocumentos','contenedor_protDocumentos','documentocrmbase');

      protDocumentos.altura = '35px';
      protDocumentos.campoid = 'idDocumentoCRMBase';
      protDocumentos.campoEliminacion = 'eliminarDocumentoCRMBase';

      protDocumentos.campos   = [
      'idDocumentoCRMBase',
      'DocumentoCRM_idBase'
      ];

      protDocumentos.etiqueta = [
      'input',
      'select'
      ];

      protDocumentos.tipo = [
      'hidden',
      ''
      ];

      protDocumentos.estilo = [
      '',
      'width: 600px;height:35px;'
      ];

      protDocumentos.clase    = ['','chosen-select'];
      protDocumentos.sololectura = [true,false];  
      protDocumentos.funciones = ['',''];
      protDocumentos.completar = ['off','off'];
      protDocumentos.opciones = ['',listaDocumentoBase];

      for(var j=0, k = documentocrmbase.length; j < k; j++)
      {
        protDocumentos.agregarCampos(JSON.stringify(documentocrmbase[j]),'L');
      }


      protGraficos = new Atributos('protGraficos','contenedor_protGraficos','documentocrmgrafico');

      protGraficos.altura = '35px';
      protGraficos.campoid = 'idDocumentoCRMGrafico';
      protGraficos.campoEliminacion = 'eliminarDocumentoCRMGrafico';

      protGraficos.campos   = [
      'idDocumentoCRMGrafico',
      'serieDocumentoCRMGrafico',
      'tituloDocumentoCRMGrafico',
      'tipoDocumentoCRMGrafico', 
      'valorDocumentoCRMGrafico'
      ];

      protGraficos.etiqueta = [
      'input',
      'select',
      'input',
      'select',
      'select'
      ];

      protGraficos.tipo = [
      'hidden',
      '',
      'text',
      '',
      ''
      ];

      protGraficos.estilo = [
      '',
      'width: 200px;height:35px;',
      'width: 400px;height:35px;',
      'width: 200px;height:35px;',
      'width: 200px;height:35px;'
      ];

      tipoGrafico = [['Barras','Dona','Linea'],['Barras','Dona','Linea']];
      serieGrafico = [['estadocrm','categoriacrm','lineanegocio','eventocrm','origencrm'],['Estado','Categoría','Línea de Negocio','Evento/Campaña', 'Origen']];
      valorGrafico = [['Valor','Cantidad'],['Valor','Cantidad']];

      protGraficos.clase    = ['','','','',''];
      protGraficos.sololectura = [true,false,false,false,false];  
      protGraficos.funciones = ['','','','',''];
      protGraficos.completar = ['off','off','off','off','off'];
      protGraficos.opciones = ['',serieGrafico,'',tipoGrafico,valorGrafico];

      for(var j=0, k = documentocrmgrafico.length; j < k; j++)
      {
        protGraficos.agregarCampos(JSON.stringify(documentocrmgrafico[j]),'L');
      }



      // protCompania = new Atributos('protCompania','contenedor_protCompania','documentocrmcompania');

      // protCompania.altura = '35px';
      // protCompania.campoid = 'idDocumentoCRMCompania';
      // protCompania.campoEliminacion = 'eliminarDocumentoCRMCompania';

      // protCompania.campos   = [
      // 'idDocumentoCRMCompania',
      // 'Compania_idCompania',
      // 'nombreCompania'
      // ];

      // protCompania.etiqueta = [
      // 'input',
      // 'input',
      // 'input'
      // ];

      // protCompania.tipo = [
      // 'hidden',
      // 'hidden',
      // 'text'
      // ];

      // protCompania.estilo = [
      // '',
      // '',
      // 'width: 860px;height:35px;'
      // ];

      // protCompania.clase    = ['','',''];
      // protCompania.sololectura = [true,true,true];  
      // protCompania.funciones = ['','',''];
      // protCompania.completar = ['off','off','off'];
      // protCompania.opciones = ['','','']

      // for(var j=0, k = documentocrmcompania.length; j < k; j++)
      // {
      //   protCompania.agregarCampos(JSON.stringify(documentocrmcompania[j]),'L');

      //   llenarDatosCompania($('#Compania_idCompania'+j).val(), j);
      // }


      protRol = new Atributos('protRol','contenedor_protRol','documentocrmrol');

      protRol.altura = '35px';
      protRol.campoid = 'idDocumentoCRMRol';
      protRol.campoEliminacion = 'eliminarDocumentoCRMRol';

      protRol.campos   = [
      'idDocumentoCRMRol',
      'Rol_idRol',
      'nombreRol',
      'adicionarDocumentoCRMRol',
      'modificarDocumentoCRMRol',
      'consultarDocumentoCRMRol',
      'anularDocumentoCRMRol',
      'aprobarDocumentoCRMRol'
      ];

      protRol.etiqueta = [
      'input',
      'input',
      'input',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox'
      ];

      protRol.tipo = [
      'hidden',
      'hidden',
      'text',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox'
      ];

      protRol.estilo = [
      '',
      '',
      'width: 530px;height:35px;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;'
      ];

      protRol.clase    = ['','','','','','','',''];
      protRol.sololectura = [true,true,true,true,true,true,true,true];  
      protRol.funciones = ['','','','','','','',''];
      protRol.completar = ['off','off','off','off','off','off','off','off'];
      protRol.opciones = ['','','','','','','','']

      for(var j=0, k = documentocrmrol.length; j < k; j++)
      {
        protRol.agregarCampos(JSON.stringify(documentocrmrol[j]),'L');

        llenarDatosRol($('#Rol_idRol'+j).val(), j);
      }
        
    });

 </script>

      @if(isset($documentocrm))
            @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
                  {!!Form::model($documentocrm,['route'=>['documentocrm.destroy',$documentocrm->idDocumentoCRM],'method'=>'DELETE'])!!}
            @else
                  {!!Form::model($documentocrm,['route'=>['documentocrm.update',$documentocrm->idDocumentoCRM],'method'=>'PUT'])!!}
            @endif
      @else
            {!!Form::open(['route'=>'documentocrm.store','method'=>'POST'])!!}
      @endif
            <div id='form-section' >
                        <fieldset id="documentocrm-form-fieldset">      
                              <div class="form-group required" id='test'>
                                    {!!Form::label('codigoDocumentoCRM', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
                                    <div class="col-sm-10">
                                    <div class="input-group">
                                          <span class="input-group-addon">
                                          <i class="fa fa-barcode"></i>
                                          </span>
                                          <input type="hidden" id="token" value="{{csrf_token()}}"/>
                                                {!!Form::text('codigoDocumentoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la Línea'])!!}
                                                {!!Form::hidden('idDocumentoCRM', null, array('id' => 'idDocumentoCRM'))!!}

                                                {!!Form::hidden('eliminarDocumentoCRMCampo', '', array('id' => 'eliminarDocumentoCRMCampo'))!!}
                                                {!!Form::hidden('eliminarDocumentoCRMBase', '', array('id' => 'eliminarDocumentoCRMBase'))!!} 
                                                {!!Form::hidden('eliminarDocumentoCRMGrafico', '', array('id' => 'eliminarDocumentoCRMGrafico'))!!} 
                                                {!!Form::hidden('eliminarDocumentoCRMRol', '', array('id' => 'eliminarDocumentoCRMRol'))!!}

                                          </div>
                                    </div>
                              </div>
                              <div class="form-group required" id='test'>
                                    {!!Form::label('nombreDocumentoCRM', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
                                    <div class="col-sm-10">
                                    <div class="input-group">
                                          <span class="input-group-addon">
                                          <i class="fa fa-pencil-square-o"></i>
                                          </span>
                                                {!!Form::text('nombreDocumentoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la Línea'])!!}
                                    </div>
                              </div>
                            </div>  
                            <div class="form-group" >
                            {!!Form::label('tipoDocumentoCRM', 'Tipo', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10" >
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-credit-card" ></i>
                                </span>
                                {!!Form::select('tipoDocumentoCRM',
                                    array('HelpDesk'=>'HelpDesk','Comercial'=>'Comercial','Gestion Humana'=>'Gestión Humana','Produccion'=>'Producción', 'Compras' => 'Compras'), (isset($documentocrm) ? $documentocrm->tipoDocumentoCRM : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de Documento"])!!}
                              </div>
                            </div>
                          </div>

                          <div class="form-group" >
                            {!!Form::label('GrupoEstado_idGrupoEstado', 'Grupo Proceso', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10" >
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-credit-card" ></i>
                                </span>
                                {!!Form::select('GrupoEstado_idGrupoEstado',
                                    $grupoestado, (isset($documentocrm) ? $documentocrm->GrupoEstado_idGrupoEstado : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el grupo de proceso"])!!}
                              </div>
                            </div>
                          </div>

                          <div class="form-group" >
                            {!!Form::label('filtroSolicitanteDocumentoCRM', 'Tipos de Solicitantes', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10" >
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-credit-card" ></i>
                                </span>
                                {!!Form::select('filtroSolicitanteDocumentoCRM',
                                
                                    array('*01*'=>'Empleados','*02*'=>'Proveedores/Contratistas','*03*'=>'Clientes'), (isset($documentocrm) ? $documentocrm->filtroSolicitanteDocumentoCRM : ''),["class" => "chosen-select form-control", "data-placeholder"=>"Seleccione el tipo de tercero...", "multiple"=>""])!!}
                              </div>
                            </div>
                          </div>

                        
                              <div class="form-group">
                            <div class="col-lg-12">
                              <div class="panel panel-default">
                                <div class="panel-heading">Configuración</div>
                                <div class="panel-body">
                                  <div class="panel-group" id="accordion">

                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#numeracion">Numeración</a>
                                        </h4>
                                      </div>
                                      <div id="numeracion" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                          
                                                      <div class="form-group" >
                                                {!!Form::label('numeracionDocumentoCRM', 'Tipo Numeración', array('class' => 'col-sm-2 control-label'))!!}
                                                <div class="col-sm-4" >
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                          <i class="fa fa-credit-card" ></i>
                                                        </span>
                                                                  {!!Form::select('numeracionDocumentoCRM',
                                                            array('Automatica'=>'Automática','Manual'=>'Manual'), 
                                                            (isset($documentocrm) ? $documentocrm->numeracionDocumentoCRM : 'Automatica'),
                                                            ["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de Numeración"])!!}
                                                      </div>
                                                    </div>
                                                  </div>


                                      <div class="form-group" >
                                                {!!Form::label('longitudDocumentoCRM', 'Longitud', array('class' => 'col-sm-2 control-label'))!!}
                                                <div class="col-sm-4" >
                                                      <div class="input-group">
                                                        <span class="input-group-addon">
                                                          <i class="fa fa-credit-card" ></i>
                                                        </span>
                                                        {!!Form::text('longitudDocumentoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa Longitud de numeración'])!!}
                                                      </div>
                                                    </div>
                                                  </div>

                                                      <div class="form-group" >
                                                      {!!Form::label('desdeDocumentoCRM', 'Desde', array('class' => 'col-sm-2 control-label'))!!}
                                                      <div class="col-sm-4" >
                                                            <div class="input-group">
                                                              <span class="input-group-addon">
                                                                <i class="fa fa-credit-card" ></i>
                                                              </span>
                                                              {!!Form::text('desdeDocumentoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa numeración inicial'])!!}
                                                            </div>
                                                      </div>
                                                  </div>

                                                      <div class="form-group" >
                                                      {!!Form::label('hastaDocumentoCRM', 'Hasta', array('class' => 'col-sm-2 control-label'))!!}
                                                      <div class="col-sm-4" >
                                                            <div class="input-group">
                                                              <span class="input-group-addon">
                                                                <i class="fa fa-credit-card" ></i>
                                                              </span>
                                                              {!!Form::text('hastaDocumentoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa numeración final'])!!}
                                                            </div>
                                                      </div>
                                                  </div>

                                           
                                        </div> 
                                      </div>
                                    </div>

                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#contenido">Contenido</a>
                                        </h4>
                                      </div>
                                      <div id="contenido" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                          
                                            <div class="panel-body">
                                              <div class="form-group" id='test'>
                                                <div class="col-sm-12">
                                                  <div class="panel-body" >
                                                    <div class="form-group" id='test'>
                                                      <div class="col-sm-12">
                                                        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                                          <div style="overflow:auto; height:350px;">
                                                            <div style="width: 100%; display: inline-block;">
                                                              <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" onclick="abrirModalCampos();">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                              </div>
                                                              <div class="col-md-1" style="width: 260px;" >Campo</div>
                                                              <div class="col-md-1" style="width: 100px;" >Consulta</div>
                                                              <div class="col-md-1" style="width: 100px;" >Formulario</div>
                                                              <div class="col-md-1" style="width: 100px;" >Obligatorio</div>
                                                              <div class="col-md-1" style="width: 100px;" >Solicitante</div>
                                                              <div class="col-md-1" style="width: 100px;" >Asesor</div>
                                                              <div class="col-md-1" style="width: 100px;" >Aprobador</div>
                                                              <div id="contenedor_protCampos">
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

                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#documentobase">Documentos Base</a>
                                        </h4>
                                      </div>
                                      <div id="documentobase" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                          
                                            <div class="panel-body">
                                              <div class="form-group" id='test'>
                                                <div class="col-sm-12">
                                                  
                                                        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                                          <div style="overflow:auto; height:350px;">
                                                            <div style="width: 100%; display: inline-block;">
                                                              <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" onclick="protDocumentos.agregarCampos(valoresDocumento,'A');">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                              </div>
                                                              
                                                              <div class="col-md-1" style="width: 600px;" >Nombre Documento</div>
                                                              
                                                            </div>
                                                            <div id="contenedor_protDocumentos">
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
                                          <a data-toggle="collapse" data-parent="#accordion" href="#graficos">Gráficos</a>
                                        </h4>
                                      </div>
                                      <div id="graficos" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                          
                                            <div class="panel-body">
                                              <div class="form-group" id='test'>
                                                <div class="col-sm-12">
                                                  <div class="panel-body" >
                                                    <div class="form-group" id='test'>
                                                      <div class="col-sm-12">
                                                        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                                          <div style="overflow:auto; height:350px;">
                                                            <div style="width: 100%; display: inline-block;">
                                                              <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" onclick="protGraficos.agregarCampos(valoresGrafico,'A');">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                              </div>
                                                              <div class="col-md-1" style="width: 200px;" >Serie</div>
                                                              <div class="col-md-1" style="width: 400px;" >Título del Gráfico</div>
                                                              <div class="col-md-1" style="width: 200px;" >Tipo</div>
                                                              <div class="col-md-1" style="width: 200px;" >Valor</div>
                                                              <div id="contenedor_protGraficos">
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
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#permisos">Roles</a>
                                        </h4>
                                      </div>
                                      <div id="permisos" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                          

                                          <div class="tab-content">
                                          
                                                   <div class="panel-body" >
                                                      <div class="form-group" id='test'>
                                                        <div class="col-sm-12">
                                                          <div class="panel-body" >
                                                            <div class="form-group" id='test'>
                                                              <div class="col-sm-12">
                                                                <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                                                                  <div style="overflow:auto; height:350px;">
                                                                    <div style="width: 100%; display: inline-block;">
                                                                      <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" onclick="abrirModalRol();">
                                                                        <span class="glyphicon glyphicon-plus"></span>
                                                                      </div>
                                                                      <div class="col-md-1" style="width: 530px;" >Rol</div>
                                                                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Adicionar" class="fa fa-plus"></span></center></div>
                                                                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Modificar" class="fa fa-pencil"></span></center></div>
                                                                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Consultar" class="fa fa-search"></span></center></div>
                                                                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Anular" class="fa fa-trash"></span></center></div>
                                                                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Aprobar" class="fa fa-check"></span></center></div>
                                                                      
                                                                      <div id="contenedor_protRol">
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
                                    </div>

                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>    



                        </fieldset> 




                        @if(isset($documentocrm))
                              {!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
                        @else
                              {!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
                        @endif
            </div>


      {!!Form::close()!!}           
            <!-- Modal -->

@stop
<div id="ModalCampos" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Campos</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="campos" name="campos" src="http://'.$_SERVER["HTTP_HOST"].'/campocrmgridselect?tipo=documentocrm"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>

<div id="ModalCompanias" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Compañías</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="companias" name="companias" src="http://'.$_SERVER["HTTP_HOST"].'/companiagridselect"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>

<div id="ModalRoles" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Roles</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="roles" name="roles" src="http://'.$_SERVER["HTTP_HOST"].'/rolgridselect"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>