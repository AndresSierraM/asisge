@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Cuadro de Mando</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/cuadromando.js')!!}
{!!Html::style('css/cerrardiv.css')!!}

	@if(isset($cuadromando))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($cuadromando,['route'=>['cuadromando.destroy',$cuadromando->idCuadroMando],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($cuadromando,['route'=>['cuadromando.update',$cuadromando->idCuadroMando],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'cuadromando.store','method'=>'POST'])!!}
	@endif
  
<script type="text/javascript">

  $(document).ready(function(){

  if(document.getElementById('CompaniaObjetivo_idCompaniaObjetivo').value > 0)
      {
        llenarObjetivo(document.getElementById('CompaniaObjetivo_idCompaniaObjetivo').value); 
      }

  // consultamos los datos de la tabla de formulas y con esta información llenamos el campo de datos a grabar formula
  var cuadromandoFormula = '<?php echo (isset($cuadromando) ? json_encode($cuadromando->cuadromandoformula) : "");?>';
  cuadromandoFormula = (cuadromandoFormula != '' ? JSON.parse(cuadromandoFormula) : '');
  var dato = '';
  document.getElementById('datosgrabar').value = '';
  for(var j=0; j < cuadromandoFormula.length; j++)
  {

   
      dato += 
          cuadromandoFormula[j].idCuadroMandoFormula+','+
          cuadromandoFormula[j].CuadroMando_idCuadroMando+','+
          cuadromandoFormula[j].tipoCuadroMandoFormula+','+
          cuadromandoFormula[j].CuadroMando_idIndicador+','+
          cuadromandoFormula[j].nombreCuadroMandoFormula+','+
          cuadromandoFormula[j].Modulo_idModulo+','+
          cuadromandoFormula[j].campoCuadroMandoFormula+','+
          cuadromandoFormula[j].calculoCuadroMandoFormula+'|';
      
      concatenarFormula(dato, cuadromandoFormula[j].nombreCuadroMandoFormula);

  }

});
</script>
{!!Html::script('js/cuadromandoagrupador.js')!!}
<script >
    var agrupadores = '<?php echo (isset($cuadromandoformula) ? json_encode($cuadromandoformula->agrupadoress) : "");?>';
    agrupadores = (agrupadores != '' ? JSON.parse(agrupadores) : '');
    var valorAgrupador = [''];

    $(document).ready(function(){

      agrupador = new Atributos('agrupador','contenedor_agrupador','agrupador_');
      agrupador.campos   = ['campoCuadroMandoAgrupador'];
      agrupador.etiqueta = ['select'];
      agrupador.tipo     = [''];
      agrupador.estilo   = ['width: 900px;height:35px;'];
      agrupador.clase    = ['chosen-select'];
      agrupador.sololectura = [false];
      for(var j=0, k = agrupadores.length; j < k; j++)
      {
        agrupador.agregarCampos(JSON.stringify(agrupadores[j]),'L');
      }

    });
</script>

{!!Html::script('js/cuadromandocondicion.js')!!}
<script>

    var cuadromandocondiciones = '<?php echo (isset($cuadromandoformula) ? json_encode($cuadromandoformula->cuadromandocondicion) : "");?>';
    cuadromandocondiciones = (cuadromandocondiciones != '' ? JSON.parse(cuadromandocondiciones) : '');

    var valorcuadromandocondicion = ['','','','','',''];

    $(document).ready(function(){

      cuadromandocondicion = new AtributosPropiedades('cuadromandocondicion','contenedor_cuadromandocondicion','cuadromandocondicion_');
      cuadromandocondicion.campos   = ['parentesisabre', 'FrecuenciaMedicion_idFrecuenciaMedicion', 'operador','fecha','parentesiscierra','agrupador'];
      cuadromandocondicion.etiqueta = ['select1', 'select2','select3','input','select4','select5'];
      cuadromandocondicion.tipo     = ['','','','text','',''];
      cuadromandocondicion.estilo   = ['width: 100px;height:35px;','width: 280px;height:35px;','width: 160px;height:35px;','width: 190px;height:35px;','width: 100px;height:35px;','width: 100px;height:35px;'];
      cuadromandocondicion.clase    = ['chosen-select','chosen-select','chosen-select','','chosen-select','chosen-select'];
      cuadromandocondicion.sololectura = [false,false,false,false,false,false];

      cuadromandocondicion.valorInicioParentesis =  Array("(", "((", "(((", "((((");
      cuadromandocondicion.nombreInicioParentesis =  Array("(", "((", "(((", "((((");

      cuadromandocondicion.valorTipo =  Array("id");
      cuadromandocondicion.nombreTipo =  Array("id");

      cuadromandocondicion.valorOperador =  Array("''", "Igual a", "Mayor que", "Mayor o igual", "Menor que", "Menor o igual que", "Contiene");
      cuadromandocondicion.nombreOperador =  Array("Seleccione", "Igual a", "Mayor que", "Mayor o igual", "Menor que", "Menor o igual que", "Contiene");

      cuadromandocondicion.valorFinParentesis =  Array(")", "))", ")))", "))))");
      cuadromandocondicion.nombreFinParentesis =  Array(")", "))", ")))", "))))");

      cuadromandocondicion.valorConector =  Array("Y", "O");
      cuadromandocondicion.nombreConector =  Array("Y", "O");

      for(var j=0, k = cuadromandocondiciones.length; j < k; j++)
      {
        cuadromandocondicion.agregarCamposPropiedades(JSON.stringify(cuadromandocondiciones[j]),'L');
      }

    });

  </script>

<div id='form-section' >

	<fieldset id="cuadromando-form-fieldset">	
  {!! Form::hidden('Compania_idCompania', 1, array('Compania_idCompania' => 'Compania_idCompania')) !!}

		<div class="form-group" id='test'>
          {!! Form::label('numeroCuadroMando', 'N&uacute;mero', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-tachometer"></i>
              </span>
              {!!Form::text('numeroCuadroMando',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero'])!!}
              {!! Form::hidden('idCuadroMando', null, array('idCuadroMando' => 'idCuadroMando')) !!}
            </div>
          </div>
        </div>

          <div class="form-group" id='test'>
            {!!Form::label('CompaniaObjetivo_idCompaniaObjetivo', 'Objetivo de la Calidad', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-pencil-square-o"></i>
                        </span>
                {!!Form::select('CompaniaObjetivo_idCompaniaObjetivo',$companiaobjetivo, (isset($cuadromando) ? $cuadromando->CompaniaObjetivo_idCompaniaObjetivo : 0),["class" => "chosen-select form-control", 'onchange'=>'llenarObjetivo(this.value)', "placeholder" =>"Seleccione el objetivo"])!!}
              </div>
            </div>
          </div>
          <input type="hidden" id="token" value="{{csrf_token()}}"/>

		
		    <div class="form-group" id='test'>
          {!! Form::label('objetivoCalidad', '&nbsp;', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-bars"></i>
              </span>
    				{!!Form::textarea('objetivoCalidad',null,['class'=>'form-control','readonly','style'=>'height:100px'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('Proceso_idProceso', 'Proceso', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
              <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-sitemap"></i>
                  </span>
                {!!Form::select('Proceso_idProceso',$proceso, (isset($cuadromando) ? $cuadromando->Proceso_idProceso : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el proceso"])!!}
              </div>
            </div>
          </div>

        <div class="form-group" id='test'>
          {!! Form::label('objetivoEspecificoCuadroMando', 'Objetivos especificos de los procesos', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-bars"></i>
              </span>
            {!!Form::textarea('objetivoEspecificoCuadroMando',null,['class'=>'form-control','style'=>'height:70px'])!!}
            </div>
          </div>
        </div>

       <div class="form-group" id='test'>
          {!! Form::label('indicadorCuadroMando', 'Nombre del indicador', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-font "></i>
              </span>
            {!!Form::text('indicadorCuadroMando',null,['class'=>'form-control','placeholder'=>'Ingrese el nombre del indicador'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('definicionIndicadorCuadroMando', 'Definici&oacute;n del indicador', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-indent"></i>
              </span>
            {!!Form::textarea('definicionIndicadorCuadroMando',null,['class'=>'form-control','style'=>'height:70px'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('formulaCuadroMando', 'Formula del indicador', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flask "></i>
              </span>
            {!!Form::text('formulaCuadroMando',null,['class'=>'form-control','readonly', 'onclick' => 'divFormula()'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('operadorMetaCuadroMando', 'Meta', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-2">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-cogs"></i>
              </span>
            {!! Form::select('operadorMetaCuadroMando', ['>' => '>', '>=' => '>=', '<' => '<', '<=' => '<=', '=' => '='], null, ['class' => 'select form-control','placeholder'=>'Seleccione'])!!}
            </div>
          </div>

          <div class="col-sm-2">
            <div class="input-group">
            {!!Form::text('valorMetaCuadroMando',null,['class'=>'form-control','placeholder'=>'&nbsp;'])!!}
            </div>
          </div>

          <div class="col-sm-6">
            <div class="input-group"> 
            {!! Form::select('tipoMetaCuadroMando', ['C' =>'C','%' => '%','$' => '$'], null, ['class' => 'select form-control','placeholder'=>'Seleccione'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('FrecuenciaMedicion_idFrecuenciaMedicion', 'Frecuencia', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-exchange"></i>
                        </span>
                {!!Form::select('FrecuenciaMedicion_idFrecuenciaMedicion',$frecuenciamedicion, (isset($cuadromando) ? $cuadromando->FrecuenciaMedicion_idFrecuenciaMedicion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la frecuencia de medeci&oacute;n"])!!}
              </div>
            </div>
          </div> 

          <div class="form-group" id='test'>
          {!! Form::label('visualizacionCuadroMando', 'Visualizaci&oacute;n', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-table"></i>
              </span>
            {!! Form::select('visualizacionCuadroMando', ['Columnas' => 'Columnas', 'Barras' => 'Barras', 'Torta' => 'Torta', 'Lineas' => 'Lineas', 'Area' => 'Area'], null, ['class' => 'chosen-select form-control','placeholder'=>'Seleccione'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('Tercero_idResponsable', 'Responsable de Medici&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-user"></i>
                        </span>
                {!!Form::select('Tercero_idResponsable',$tercero, (isset($cuadromando) ? $cuadromando->Tercero_idResponsable : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el responsable"])!!}
              </div>
            </div>
          </div>



  <div class="col-md-6" id="formula" style="width: 100%; height:100%; background-color: white; z-index: 2 ; border: 1px inset; border-color: #ddd; position: absolute; top: 1px; display: none;">
    <a class='cerrar' href='javascript:void(0);' onclick='document.getElementById(&apos;formula&apos;).style.display = &apos;none&apos;'>x</a> <!--Es la funcion la cual cierra el div flotante-->
    
    <div class="col-md-6" id="uno" style="width: 540px; height:290px; background-color: white; border: 1px solid; border-color: #ddd; position: absolute; top: 1px; display: block;">
    <div id="operadores">
      {!! HTML::image('images/mas.png','mas',array("class"=>"btn btn-success",'width' => '52', 'height' => '52',  'onclick' => 'concatenarDatos("Operador","+")','title' => 'mas')) !!}
      {!! HTML::image('images/menos.png','menos',array("class"=>"btn btn-success",'width' => '52', 'height' => '52',  'onclick' => 'concatenarDatos("Operador","-")','title' => 'menos')) !!}
      {!! HTML::image('images/multiplicacion.png','multiplicacion',array("class"=>"btn btn-success",'width' => '52', 'height' => '52', 'onclick' => 'concatenarDatos("Operador","*")','title' => 'multiplicacion')) !!}
      {!! HTML::image('images/division.png','division',array("class"=>"btn btn-success",'width' => '52', 'height' => '52',  'onclick' => 'concatenarDatos("Operador","/")','title' => 'division')) !!}
      {!! HTML::image('images/parentesisabre.png','parentesisabre',array("class"=>"btn btn-success",'width' => '52', 'height' => '52',  'onclick' => 'concatenarDatos("Operador","(")','title' => 'parentesisabre')) !!}
      {!! HTML::image('images/parentesiscierra.png','parentesiscierra',array("class"=>"btn btn-success",'width' => '52', 'height' => '52' , 'onclick' => 'concatenarDatos("Operador",")")','title' => 'parentesiscierra')) !!}
    </div>

    <div id="indicadores" style="margin:4px 0px 0px 0px;">
      <span id="indicadorformula" class="btn btn-primary" style="height:52px; width:108px;" onclick="mostrarDiv('formIndicador')">
        {!! HTML::image('images/indicador.png','indicador',array('width' => '32', 'height' => '32','title' => 'Indicador')) !!}
      </span>
      <span id="constanteformula" class="btn btn-warning"  style="height:52px; width:108px;" onclick="mostrarDiv('formConstante')">
        {!! HTML::image('images/pi.png','constante',array('width'=>'32', 'height' => '32','title' => 'Pi')) !!}
      </span>
      <span id="variableformula" class="btn btn-info"  style="height:52px; width:108px;" onclick="mostrarDiv('formVariable')">
        {!! HTML::image('images/funcion.png','variable',array('width'=>'32', 'height' => '32','title' => 'Variable')) !!}
      </span>
    </div>

    <div id="borrar" style="margin:4px 0px 0px 0px;">
      <span id="borrartodo">
      {!!Form::button('Borrar TODO',["class"=>"btn btn-danger", 'style'=>'height:52px; width:164px;', 'onclick' => 'borrarTodo();'])!!}
      </span>
      <span id="borrarultimo">
      {!!Form::button('Borrar ULTIMO',["class"=>"btn btn-danger", 'style'=>'height:52px; width:164px;', 'onclick' => 'borrarTodo();'])!!}
      </span>
    </div>

    </br>
    <div id="concatenado">
        {!!Form::text('indica',null,['class'=>'form-control','style'=>'width:70px; height:30px;','placeholder'=>'F(x)'])!!}
        {!!Form::hidden('formulaconcatenada','',['id' => 'formulaconcatenada'])!!}
        <div id="contenedorFormula"></div>
        {!!Form::hidden('datosgrabar','',['id' => 'datosgrabar'])!!}
        {!!Form::hidden('contadorFormula',0,['id' => 'contadorFormula'])!!}
        
    </div>

    </div>
    

    <div class="col-md-6" id="formIndicador" style="width: 540px; height:290px; background-color: white; border: 1px solid; border-color: #ddd; position: absolute; top: 1px; left:560px; display: none;">
        <div id="operadores">
          {!! Form::label('Indicador', 'Indicador', array('class' => 'col-sm-2 control-label')) !!}
          {!! Form::select('Indicador', $indicador, null, ['class' => 'select form-control col-sm-1', 'placeholder'=>'Seleccione un Indicador'])!!}
        </div>
        </br>
        {!!Form::button('Enviar',["class"=>"btn btn-success", 'onclick' => 'concatenarDatos(\'formIndicador\',document.getElementById(\'Indicador\').options[document.getElementById(\'Indicador\').selectedIndex].text);'])!!}
    </div>

    <div class="col-md-6" id="formConstante" style="width: 540px; height:290px; background-color: white; border: 1px solid; border-color: #ddd; position: absolute; top: 1px; left:560px; display: none;">
        <div id="operadores">
        </br>
          {!! Form::label('valorConstante', 'Valor', array('class' => 'col-sm-2 control-label')) !!}
          {!!Form::text('valorConstante',null,['class'=>'form-control','placeholder'=>'&nbsp;'])!!}
          </br>
          {!!Form::button('Enviar',["class"=>"btn btn-success", 'onclick' => 'concatenarDatos(\'formConstante\',document.getElementById(\'valorConstante\').value);'])!!}
        </div>
    </div>

    <div class="col-md-6" id="formVariable" style="width: 540px; height:290px; background-color: white; border: 1px solid; border-color: #ddd; position: absolute; top: 1px; left:560px; display: none;">
        <div id="variables">

          <div class="form-group" id='test'>
          {!! Form::label('nombreVariable', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
            {!!Form::text('nombreVariable',null,['class'=>'form-control', 'style' => 'width:258px;', 'placeholder'=>'Nombre de la Variable'])!!}
            </div>
          </div>
        </div>
          <!-- Modulo_idModulo -->
          <div class="form-group" id='test'>
          {!! Form::label('Modulo_idModulo', 'Modulo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
            {!!Form::select('Modulo_idModulo',$modulo, (isset($cuadromando) ? $cuadromando->Modulo_idModulo : 0),["class" => "select form-control", 'style' => 'width:258px;', 'onchange' => 'consultarCampos(this.value)',"placeholder" =>"Seleccione el modulo"])!!}
            </div>
          </div>
          </div>
          <input type="hidden" id="token" value="{{csrf_token()}}"/>
          
          <!-- Consulta a la bd -->
          <div class="form-group" id='test'>
          {!! Form::label('campoCuadroMandoFormula', 'Campo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
            {!!Form::select('campoCuadroMandoFormula',array(), '',["class" => "select form-control", 'style' => 'width:258px;', 'onchange' => 'consultarCalculos(document.getElementById(\'Modulo_idModulo\').value, this.value)', "placeholder" =>"Seleccione..."])!!}
            </div>
          </div>
          </div>

          <div class="form-group" id='test'>
          {!! Form::label('calculoCuadroMandoFormula', 'Calculo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
            {!! Form::select('calculoCuadroMandoFormula', ['Ninguno' => 'Ninguno'], null, ['class' => 'select form-control', 'style' => 'width:259px;', 'placeholder'=>'Seleccione el calculo'])!!}
            </div>
          </div>
          </div>

          <!-- Es la multi registro -->
          <div class="form-group" id='test'>
          {!! Form::label('tipoCuadroMandoFormula', 'Condicion', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
            {!!Form::text('tipoCuadroMandoFormula',null,['class'=>'form-control', 'onclick' => 'mostrarDivCA("condicion")', 'readonly', 'style' => 'width:258px;'])!!}
            </div>
          </div>
        </div>

        <!-- Consulta a la bd -->
        <div class="form-group" id='test'>
          {!! Form::label('nombreCuadroMandoFormula', 'Agrupador', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
            {!!Form::text('nombreCuadroMandoFormula',null,['class'=>'form-control', 'onclick' => 'mostrarDivCA("agrupador")', 'readonly', 'style' => 'width:258px;'])!!}
            </div>
          </div>
        </div>
        </br>
            {!!Form::button('Enviar',["class"=>"btn btn-success", 'onclick' => 'concatenarDatos(\'formVariable\',document.getElementById(\'nombreVariable\').value);'])!!}
        </div>
    </div>
    
    <!-- Es la multi registro -->
    <div class="col-md-6" id="condicion" onclick="mostrarDivCA('condicion')" style="width: 1085px; height:290px; background-color: white; border: 1px solid; border-color: #ddd; position: absolute; top: 300px;  display: none;">
        <div id="operadores">
          <div class="panel-body">
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid">
                <div class="col-md-1" style="width: 40px;" onclick="cuadromandocondicion.agregarCamposPropiedades(valorcuadromandocondicion,'A')">
                  <span class="glyphicon glyphicon-plus"></span>
                </div>
                <div class="col-md-1" style="width: 100px;">&nbsp;</div>
                <div class="col-md-1" style="width: 280px;">Frecuencia</div>
                <div class="col-md-1" style="width: 160px;">Operador</div>
                <div class="col-md-1" style="width: 190px;">Fecha</div>
                <div class="col-md-1" style="width: 100px;">&nbsp;</div>
                <div class="col-md-1" style="width: 100px;">&nbsp;</div>
                <div id="contenedor_cuadromandocondicion">
                </div>
              </div>
            </div>
          </div>
        </div>    
        </div>
    </div>

    <div class="col-md-6" id="agrupador" style="width: 1085px; height:290px; background-color: white; border: 1px solid; border-color: #ddd; position: absolute; top: 300px; display: none;">
        <div id="operadores">
          <div class="panel-body">
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid">
                <div class="col-md-1" style="width: 40px;" onclick="agrupador.agregarCampos(valorAgrupador,'A')">
                  <span class="glyphicon glyphicon-plus"></span>
                </div>
                <div class="col-md-1" style="width: 900px;">Agrupado por</div>
                <div id="contenedor_agrupador">
                </div>
              </div>
            </div>
          </div>
        </div>    
        </div>
    </div>



  </div>
 



           



    </fieldset>
	@if(isset($cuadromando))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif
	{!! Form::close() !!}
</div>
@stop