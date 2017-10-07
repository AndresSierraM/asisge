@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Líneas de Producto</center></h3>@stop

@section('content')
  @include('alerts.request')
{!!Html::script('js/lineaproducto.js')!!}

	@if(isset($lineaproducto))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($lineaproducto,['route'=>['lineaproducto.destroy',$lineaproducto->idLineaProducto],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($lineaproducto,['route'=>['lineaproducto.update',$lineaproducto->idLineaProducto],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'lineaproducto.store','method'=>'POST'])!!}
	@endif

<script>
 var SubLineaProductoE = '<?php echo (isset($sublinea) ? json_encode($sublinea) : "");?>';
SubLineaProductoE = (SubLineaProductoE != '' ? JSON.parse(SubLineaProductoE) : '');

var sublineaproductoM = [0,'',''];
$(document).ready( function () {

// // multiregistro          
          sublineaproducto = new Atributos('sublineaproducto','sublineaproducto_Modulo','sublineadescripcion_');
          sublineaproducto.campoid = 'idSublineaProducto';  //hermanitas             
          sublineaproducto.campoEliminacion = 'eliminarsublinea';//hermanitas         Cuando se utilice la funcionalidad 
          sublineaproducto.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          sublineaproducto.campos = ['idSublineaProducto','codigoSublineaProducto','nombreSublineaProducto']; //[arrays ]
          sublineaproducto.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          sublineaproducto.etiqueta = ['input','input','input'];
          sublineaproducto.tipo = ['hidden','text','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          sublineaproducto.estilo = ['','width:300px; height:35px;','width:300px; height:35px;'];
          // estas propiedades no son muy usadas PERO SON UTILES
          sublineaproducto.clase = ['',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          sublineaproducto.sololectura = [false,false,false,]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          sublineaproducto.completar = ['off','off','off']; //autocompleta 
          sublineaproducto.opciones = ['','','']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"]; 
          sublineaproducto.funciones  = ['','',quitacarac];


        //Llenado de campos de las Multiregistro
              for(var j=0, k = SubLineaProductoE.length; j < k; j++)
              {
                 sublineaproducto.agregarCampos(JSON.stringify(SubLineaProductoE[j]),'L');
               }
});

</script>

<div id='form-section' >
	<fieldset id="lineaproducto-form-fieldset">	
		<div class="form-group required" id='test'>
          {!! Form::label('codigoLineaProducto', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoLineaProducto',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la Línea'])!!}
              {!! Form::hidden('idLineaProducto', null, array('id' => 'idLineaProducto')) !!}
              {!!Form::hidden('eliminarsublinea', null, array('id' => 'eliminarsublinea')) !!}
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
            </div>
          </div>
        </div>
    		<div class="form-group required" id='test'>
              {!! Form::label('nombreLineaProducto', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-pencil-square-o "></i>
                  </span>
    				{!!Form::text('nombreLineaProducto',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la Línea',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
                </div>
              </div>
        </div>


        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Detalle</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                   <div class="panel-body">
                      <div class="form-group" id='test'>
                          <div class="col-sm-12">
                              <div class="row show-grid">
                              <div class="col-md-1" style="width: 40px;height: 35px;" onclick="sublineaproducto.agregarCampos(sublineaproductoM,'A')">
                                    <span class="glyphicon glyphicon-plus"></span>
                                  </div>
                                  <div class="col-md-1 requiredMulti" style="width: 300px;display:inline-block;height:35px;">Codigo SubLinea</div>
                                  <div class="col-md-1 requiredMulti" style="width: 300px;display:inline-block;height:35px;">Nombre Sublinea</div>        
                                  <!-- este es el div para donde van insertando los registros --> 
                                  <div id="sublineaproducto_Modulo">
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
    <br>
	@if(isset($lineaproducto))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
 	@endif
	{!! Form::close() !!}
</div>
@stop