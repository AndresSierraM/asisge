@extends('layouts.menufirma')

@section('titulo')<h3 id="titulo"><center>Entrega de Elementos de </br> Protecci&oacute;n Personal Firma</center></h3>@stop

@section('content')
@include('alerts.request')


{!!Html::script('js/entregaelementoproteccionfirma.js')!!}

{!!Html::style('css/signature-pad.css'); !!}
{!!Html::style('css/cerrardiv.css'); !!} 

<script>


  $(document).ready( function () {
// para que oculte el pad de firmas cuando entre al documento por primera vez, y no aparezca abierto
        mostrarFirma();
    });


</script>       

<div class="container">
	<br>
	<div class="form-group">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<!-- <div class="panel-heading">&nbsp;</div> -->
				<div class="panel-body">							
					<div class="form-group" id='test'>
						<FONT COLOR="black"> {!!Form::label('Tercero_idTercero', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}</FONT>       
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
								</span>
								<input type="hidden" id="token" value="{{csrf_token()}}"/>
								{!!Form::select('Tercero_idTercero',$EntregaEPP, (isset($entregaelementoproteccion) ? $entregaelementoproteccion->Tercero_idTercero : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el empleado"])!!}
              
							</div>
						</div>
					</div>					
					<center>
						<div class="form-group col-md-6" id='test' >
	                  		<button class="btn btn-primary" type="button" onclick="llenarTercero($('#Tercero_idTercero').val())" style="width: 30%;padding-left:auto;">Buscar</button>
	            		</div>	
            		</center>								                					
				</div>				
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<!-- <div class="panel-heading">&nbsp;</div> -->
				<div class="row">
			        <div class="col-sm-offset-1 col-sm-8" id="prueba">  
			        <br> 
			             	<table class="table table-striped table-bordered" width="100%" id="tablaacta">					
							</table>
			        </div>
	    		</div>			
			</div>			
		</div>			
	</div>			     
</div>

 <div id="signature-pad" class="m-signature-pad"    >
        <a class='cerrar' href='javascript:void(0);' onclick='cerrarDivFirma(); document.getElementById(&apos;signature-pad&apos;).style.display = &apos;none&apos;'>x</a> 
            <input type="hidden" id="signature-reg" value="">
            <div class="m-signature-pad--body">
              <canvas></canvas>
            </div>
            <div class="m-signature-pad--footer">
              <div class="description">Firme sobre el recuadro</div>
              <button type="button" class="button clear btn btn-danger" data-action="clear">Limpiar</button>
              <button type="button" class="button save btn btn-success"  onclick="actualizarFirma()">Guardar Firma</button>
                <img id="firma" style="width:200px; height: 150px; border: 1px solid; display:none;"  src="">
                {!!Form::hidden('firmabase64', null, array('id' => 'firmabase64'))!!}        
                {!!Form::hidden('idEntregaElementoProteccion', null, array('id' => 'idEntregaElementoProteccion'))!!}
            </div>
        </div>

{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app1.js'); !!}
@stop