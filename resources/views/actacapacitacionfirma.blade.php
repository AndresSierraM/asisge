@extends('layouts.menufirma')


@section('titulo')<h3 id="titulo"><center>Acta  Capacitaci&oacute;n Firma</center></h3>@stop

@section('content')
@include('alerts.request')


{!!Html::script('js/actacapacitacionfirma.js')!!}

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
						<FONT COLOR="black">{!!Form::label('numeroActaCapacitacion', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}</FONT>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
								</span>
								<input type="hidden" id="token" value="{{csrf_token()}}"/>
								{!!Form::text('numeroActaCapacitacion',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero'])!!}
							</div>
						</div>
					</div>					
					<center>
						<div class="form-group col-md-6" id='test' >
	                  		<button class="btn btn-primary" type="button" onclick="llenartercero($('#numeroActaCapacitacion').val())" style="width: 30%;padding-left:auto;">Buscar</button>
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

 <div id="signature-pad" class="m-signature-pad">
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
                {!!Form::hidden('idActaCapacitacion', null, array('id' => 'idActaCapacitacion'))!!}             
                {!!Form::hidden('idAsistente', null, array('id' => 'idAsistente'))!!}
            </div>
        </div>


{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app1.js'); !!}
@stop