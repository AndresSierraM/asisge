<?php 
$idEstadoDefault = null;
$nombreEstadoDefault = '';
foreach ($estado as $key => $value) {
	$idEstadoDefault = $key;
	$nombreEstadoDefault = $value;
	break;
}
if (!empty($movimientoCRMTarea)) 
{
	$camposAgendaTarea = array();
	// por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
	for ($i = 0, $c = count($movimientoCRMTarea); $i < $c; ++$i) 
	{
	  $camposAgendaTarea[$i] = (array) $movimientoCRMTarea[$i];
	}	
}

					              
function mostrarCampo($arrayCampos, $campo, $rolUsuario, $atributo)
{
	// recorremos el array verificando si en la columna nombreCampoCRM existe el valor del parametro $campo
	$sololectura = '';
	
	for($i=0; $i < count($arrayCampos); $i++)
	{
		if($arrayCampos[$i]["nombreCampoCRM"] == $campo)
		{
			// con esta posicion, verificamos si el Sub-rol tiene permiso o no
			$sololectura = ($arrayCampos[$i][$rolUsuario."DocumentoCRMCampo"] == 0
				? ($atributo == 'select' ? 'disabled' : 'readonly')
				: '');
		}
	}
	return $sololectura;
}	

// establecemos el SUB-ROL (solicitante, asesor o Aprobador) del tercero loqueado
// si es un documento nuevo e ingresó es porque es Solicitante pero en los permisos puede tener opcion de Aprobador
$aprobador = (isset($_GET["aprobador"]) ? $_GET["aprobador"] : 0);

// el valor por defecto será SOLICITANTE
$rolUsuario = 'solicitante';
// si estamos en ADICION
if(!isset($movimientocrm))
{
	// y es APROBADOR
	if($aprobador == 1)
	{
		$rolUsuario = 'aprobador';
	}
	else // sino se asume como SOLICITANTE
	{
		$rolUsuario = 'solicitante';
	}
}
// si estamos en EDICION/ELIMINACION
else
{
	// si esta en el documento a modificar en uno de los 3 subrolres 
	// o si no esta pero en los permisos del documento esa probador
	if($aprobador == 1)
		$rolUsuario = 'aprobador';
	else
	{
		if($movimientocrm->Tercero_idSupervisor == \Session::get("idTercero"))
		{
			$rolUsuario = 'aprobador';
		}
		elseif($movimientocrm->Tercero_idAsesor == \Session::get("idTercero"))
		{	
			$rolUsuario = 'asesor';
		}
		else
		{
			$rolUsuario = 'solicitante';
		}
	}
}

//****************************
// CONSULTAMOS EL TERCERO
// PARA SABER SI ES SOLICITANTE
// SUPERVISOR O CREADOR, PARA
// HABILITAR LOS CAMPOS
//****************************
// Reglas :
// USUARIO CREADOR: si es el usuario creador ocultamos campos que por logica no debe llenar
//					como 
// CAMPO 						CREADOR 	SUPERVISOR 		ASESOR
// Fecha Estimada solución 										X
// Fecha Vencimiento 				X
// Fecha Real Solución 											X
// Prioridad 						X
// Días Estimados Solución 						X				X
// Días Reales Solución 			X  			X 				X
// Solicitante 						X 			X 				X
// Supervisor 						
// Asesor 							
// Categoría 						
// Línea de Negocio 				
// Origen 							
// Estado 							
// Acuerdo Servicio 				
// Evento / Campaña 				
// Detalles 						
// Solución 						
// Valor 							
// Asistentes 						
// Documentos 						

// ***************************
//	CONSULTAMOS LOS CAMPOS A
//  MOSTRAR EN EL FORMULARIO
//
//****************************
$id = isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : 0; 
$campos = DB::select(
    'SELECT codigoDocumentoCRM, nombreDocumentoCRM, nombreCampoCRM,descripcionCampoCRM, 
    	solicitanteDocumentoCRMCampo, asesorDocumentoCRMCampo, aprobadorDocumentoCRMCampo, 
    	relacionTablaCampoCRM, relacionNombreCampoCRM, relacionAliasCampoCRM,
    	numeracionDocumentoCRM, longitudDocumentoCRM, desdeDocumentoCRM,
    	hastaDocumentoCRM, actualDocumentoCRM
    FROM documentocrm
    left join documentocrmcampo
    on documentocrm.idDocumentoCRM = documentocrmcampo.DocumentoCRM_idDocumentoCRM
    left join campocrm
    on documentocrmcampo.CampoCRM_idCampoCRM = campocrm.idCampoCRM
    where documentocrm.idDocumentoCRM = '.$id.' and mostrarVistaDocumentoCRMCampo = 1');

$arrayCampos = array();

$camposVista = '';
for($i = 0; $i < count($campos); $i++)
{
    $arrayCampos[] = get_object_vars($campos[$i]); 
    
    $camposVista .= $arrayCampos[$i]["nombreCampoCRM"].',';
}

$idMovimientoCRMA = (isset($movimientocrm->idMovimientoCRM) ? $movimientocrm->idMovimientoCRM : 0);


// dependiendo del tipo de numeración debemos habilitar o no el campo de numero 
// Numeracion Automatica
// Numeración Manual
if($arrayCampos[0]["numeracionDocumentoCRM"] == 'Automatica' )
	$ReadOnlyNumero = 'readonly';
else
	$ReadOnlyNumero = '';


// consultamos el tercero asociado al  usuario logueado, para 
// relacionarlo al campo de solicitante
$tercero  = DB::select(
    'SELECT idTercero, nombreCompletoTercero
    FROM tercero
    where idTercero = '.\Session::get('idTercero'));
$tercero = get_object_vars($tercero[0]); 


$fechahora = Carbon\Carbon::now();
?>

@extends('layouts.grid')
@section('titulo')<h3 id="titulo">
<center>
<?php 
	echo '('.$arrayCampos[0]["codigoDocumentoCRM"].') '.$arrayCampos[0]["nombreDocumentoCRM"].'<br>'.
		strtoupper($rolUsuario);
?></center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/agenda.js')!!}
{!!Html::script('js/movimientocrm.js'); !!}

{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->



<script>
	
	var movimientoCRMAsistentes = '<?php echo (isset($movimientocrm) ? json_encode($movimientocrm->movimientoCRMAsistentes) : "");?>';
	movimientoCRMAsistentes = (movimientoCRMAsistentes != '' ? JSON.parse(movimientoCRMAsistentes) : '');

	var movimientoCRMArchivo = '<?php echo (isset($movimientocrm) ? json_encode($movimientocrm->movimientoCRMArchivos) : "");?>';
		movimientoCRMArchivo = (movimientoCRMArchivo != '' ? JSON.parse(movimientoCRMArchivo) : '');

	var movimientocrmvacante = '<?php echo (isset($movimientocrmcargo) ? json_encode($movimientocrmcargo) : "");?>';
		movimientocrmvacante = (movimientocrmvacante != '' ? JSON.parse(movimientocrmvacante) : '');

	var movimientoCRMTarea = '<?php echo (isset($movimientoCRMTarea) ? json_encode($movimientoCRMTarea) : "");?>';
	movimientoCRMTarea = (movimientoCRMTarea != '' ? JSON.parse(movimientoCRMTarea) : '');

	var movimientoCRMProductoServicio = '<?php echo (isset($movimientoCRMProductoServicio) ? json_encode($movimientoCRMProductoServicio) : "");?>';
	movimientoCRMProductoServicio = (movimientoCRMProductoServicio != '' ? JSON.parse(movimientoCRMProductoServicio) : '');

	var valorAsistentes = [0,'','','','',''];
	var valorArchivo = [0,'','',''];
	var valorProductoServicio = [0,'','',1,1,1];

	valorEstado =  Array("En proceso", "Finalizado");
    nombreEstado =  Array("En proceso", "Finalizado");

    var estadoAgendaCRM = [valorEstado,nombreEstado];

    calcultarValorCantidad = ['onchange','calcularValorTotal(this.id, "cantidad")'];
    calcultarValorUnitario = ['onchange','calcularValorTotal(this.id, "unitario")'];

	$(document).ready(function(){
		// Se agrega  para  cuando esté editando en el ready vuelva a llamar la  función para que el ejecute  y ponga en el input el resultado, separado por puntos
							if ($("#valorMovimientoCRM").val() != '')
							{
								valorDecimal($("#valorMovimientoCRM").val());
							}
		 				
							$('#fechaHoraInicioAgenda').datetimepicker(({
    							format:'DD-MM-YYYY HH:mm:ss'
							}));

							if ($("#fechaHoraInicioAgenda").val() != '')
							{
								calcularHoras();
								calcularPesoTarea($("#tiempoTotalAgendaTarea").val());
							}
		asistentes = new Atributos('asistentes','contenedor_asistentes','asistentes_');
		asistentes.campos = ['idMovimientoCRMAsistente','nombreMovimientoCRMAsistente','cargoMovimientoCRMAsistente','telefonoMovimientoCRMAsistente','correoElectronicoMovimientoCRMAsistente'];
		asistentes.etiqueta = ['input','input','input','input','input'];
		asistentes.tipo = ['hidden','text','text','text','text'];
		asistentes.estilo = ['','width: 330px; height:35px;','width: 270px;height:35px;','width: 150px;height:35px;','width: 230px;height:35px;'];
		asistentes.clase = ['','','','',''];
		asistentes.sololectura = [false,false,false,false,false];

		
		for(var j=0, k = movimientoCRMAsistentes.length; j < k; j++)
		{
			asistentes.agregarCampos(JSON.stringify(movimientoCRMAsistentes[j]),'L');
		}

		// for(var j=0, k = movimientoCRMArchivo.length; j < k; j++)
		// {
		// 	archivo.agregarCampos(JSON.stringify(movimientoCRMArchivo[j]),'L');
		// }


		// // Multiregistro Opcion Nueva VACANTES           
          documentocrmcargo = new Atributos('documentocrmcargo','documentocrmcargo_Modulo','documentocrmcargodescripcion_');

          documentocrmcargo.campoid = 'idDocumentoCRMCargo';  //hermanitas             
          documentocrmcargo.campoEliminacion = 'eliminardocumentocrmcargo';//hermanitas         Cuando se utilice la funcionalidad 
          documentocrmcargo.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          documentocrmcargo.campos = ['idMovimientoCRMCargo','nombreCargo','Cargo_idCargo','vacantesMovimientoCRMCargo','salarioBaseCargo','fechaEstimadaMovimientoCRMCargo']; //[arrays ]
          documentocrmcargo.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          documentocrmcargo.etiqueta = ['input','input','input','input','input','input'];
          documentocrmcargo.tipo = ['hidden','text','hidden','text','text','date']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          documentocrmcargo.estilo =  ['','width: 230px;height:35px;background-color:#EEEEEE;','','width: 230px; height:35px;','width: 230px; height:35px;;background-color:#EEEEEE;','width: 230px; height:35px;']; 

          // estas propiedades no son muy usadas PERO SON USUARIOTILES
          
          documentocrmcargo.clase = ['','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          documentocrmcargo.sololectura = [false,true,false,false,true,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          documentocrmcargo.completar = ['off','off','off','off','off','off']; //autocompleta 
          
          documentocrmcargo.opciones = ['','','','','','']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          documentocrmcargo.funciones  = ['','','','','','']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  

		for(var j=0, k = movimientocrmvacante.length; j < k; j++)
		{
			documentocrmcargo.agregarCampos(JSON.stringify(movimientocrmvacante[j]),'L');
			
		}

		// ************************
		// T A R E A S
		// ************************

		tareas = new Atributos('tareas','contenedor_tareas','tareas_');

	    tareas.altura = '35px';
	    tareas.campoid = 'idMovimientoCRMTarea';
	    tareas.campoEliminacion = 'eliminarAgendaTarea';

	    tareas.campos   = [
	    'CategoriaAgenda_idCategoriaAgenda', 
	    'nombreCategoriaAgendaTarea', 
	    'asuntoAgendaTarea', 
	    'ubicacionAgendaTarea', 
	    'fechaInicioAgendaTarea', 
	    'fechaFinAgendaTarea', 
	    'horasAgendaTarea', 
	    'Tercero_idResponsable', 
	    'nombreResponsableAgenda', 
	    'pesoAgendaTarea', 
	    'ejecuionAgendaTarea', 
	    'estadoAgendaTarea', 
	    'idAgenda'];

	    tareas.etiqueta = [
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input', 
	    'input'];

	    tareas.tipo     = [
	    'hidden', 
	    'text', 
	    'text', 
	    'text', 
	    'text', 
	    'text', 
	    'text', 
	    'hidden', 
	    'text', 
	    'text', 
	    'text', 
	    'text', 
	    'hidden'];

	    tareas.estilo   = [
	    '', 
	    'width: 120px;height:35px;', 
	    'width: 120px;height:35px;', 
	    'width: 100px;height:35px;', 
	    'width: 80px;height:35px;', 
	    'width: 80px;height:35px;', 
	    'width: 80px;height:35px;', 
	    '', 
	    'width: 150px;height:35px;', 
	    'width: 80px;height:35px;', 
	    'width: 100px;height:35px;', 
	    'width: 100px;height:35px;', 
	    ''];

	    tareas.clase    = ['', '', '', '', '', '', '', '', '', '', '', '', ''];
	    tareas.sololectura = [true, true, true, true, false, false, false, true, true, false, false, false, true];
	    tareas.opciones ['', '', '', '', '', '', '', '', '', '', '', '', ''];

	    for(var j=0, k = movimientoCRMTarea.length; j < k; j++)
	    {
	      tareas.agregarCampos(JSON.stringify(movimientoCRMTarea[j]),'L');
	      console.log(JSON.stringify(movimientoCRMTarea[j]))
	      asignarFechAgenda(movimientoCRMTarea[j]['fechaInicioAgendaTarea'], movimientoCRMTarea[j]['fechaFinAgendaTarea'], j);
	    }

	    // *************************
		// F I C H A  T E C N I C A
		// *************************

          productoservicio = new Atributos('productoservicio','contenedor_productoservicio','productoservicio_');

          productoservicio.campoid = 'idMovimientoCRMProducto';             
          productoservicio.campoEliminacion = 'eliminarMovimientoCRMPRoducto';
          productoservicio.botonEliminacion = true;

          productoservicio.campos = ['FichaTecnica_idFichaTecnica','referenciaMovimientoCRMProducto','descripcionMovimientoCRMProducto','cantidadMovimientoCRMProducto','valorUnitarioMovimientoCRMProducto','valorTotalMovimientoCRMProducto', 'idMovimientoCRMProducto'];
          productoservicio.altura = '35px;'; 

          productoservicio.etiqueta = ['input','input','input','input','input','input', 'input'];
          productoservicio.tipo = ['hidden','text','text','text','text','text', 'hidden']; 
          productoservicio.estilo =  ['','width: 200px;height:35px;','width: 400px; height:35px;','width: 100px; height:35px;','width: 150px; height:35px;','width: 150px; height:35px;', '']; 

          productoservicio.clase = ['','','','','','','']; 
          productoservicio.sololectura = [false,true,true,false,false,true, false]; 
          productoservicio.completar = ['off','off','off','off','off','off', 'off']; 
          productoservicio.opciones = ['','','','','','','']; 
          productoservicio.funciones  = ['','','',calcultarValorCantidad,calcultarValorUnitario,'',''];

		for(var j=0, k = movimientoCRMProductoServicio.length; j < k; j++)
		{
			productoservicio.agregarCampos(JSON.stringify(movimientoCRMProductoServicio[j]),'L');
			calcularValorTotal(j, '');
			
		}
	});
</script>

	@if(isset($movimientocrm))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($movimientocrm,['route'=>['movimientocrm.destroy',$movimientocrm->idMovimientoCRM],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($movimientocrm,['route'=>['movimientocrm.update',$movimientocrm->idMovimientoCRM],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'movimientocrm.store','method'=>'POST'])!!}
	@endif
		<div id='form-section' >
				<fieldset id="movimientocrm-form-fieldset">	
					<div class="form-group" id='test'>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('numeroMovimientoCRM', 'Número', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-barcode"></i>
					              	</span>
					              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
									{!!Form::text('numeroMovimientoCRM',(isset($movimientocrm) ? $movimientocrm->numeroMovimientoCRM : ($ReadOnlyNumero != '' ? 'Automatico' : null)),[$ReadOnlyNumero => $ReadOnlyNumero, 'class'=>'form-control','placeholder'=>'Ingresa el número del caso'])!!}
							      	{!!Form::hidden('idMovimientoCRM', null, array('id' => 'idMovimientoCRM'))!!}
							      	{!!Form::hidden('DocumentoCRM_idDocumentoCRM', $id, array('id' => 'DocumentoCRM_idDocumentoCRM'))!!}
							      	{!!Form::hidden('eliminardocumentocrmcargo', $id, array('id' => 'eliminardocumentocrmcargo'))!!}
							      	{!!Form::hidden('rolUsuario', $rolUsuario, array('id' => 'rolUsuario'))!!}
							      	{!!Form::hidden('nombreDocumentoCRM', $arrayCampos[0]["nombreDocumentoCRM"], array('id' => 'nombreDocumentoCRM'))!!}
				        			
				        			{!!Form::hidden('Tercero_idAsesor', (isset($movimientocrm) ? $movimientocrm->Tercero_idAsesor : null), array('id' => 'Tercero_idAsesor'))!!}
				        			{!!Form::hidden('Tercero_idSupervisor', (isset($movimientocrm) ? $movimientocrm->Tercero_idSupervisor : null), array('id' => 'Tercero_idSupervisor'))!!}
				        			{!!Form::hidden('AcuerdoServicio_idAcuerdoServicio', (isset($movimientocrm) ? $movimientocrm->AcuerdoServicio_idAcuerdoServicio : null), array('id' => 'AcuerdoServicio_idAcuerdoServicio'))!!}


								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('asuntoMovimientoCRM', 'Asunto', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('asuntoMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el asunto del caso'])!!}
					    		</div>
					    	</div>
					    </div>
					    <?php
						
							if(strpos($camposVista, 'OrigenCRM_idOrigenCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('OrigenCRM_idOrigenCRMSel', 'Origen', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	
					              	@if(mostrarCampo($arrayCampos, 'OrigenCRM_idOrigenCRM', $rolUsuario,'select') == '')
					              		{!!Form::select('OrigenCRM_idOrigenCRM',$origen, (isset($movimientocrm) ? $movimientocrm->OrigenCRM_idOrigenCRM : null),["class" => "chosen-select form-control"])!!}
					              	@else
					        			{!!Form::hidden('OrigenCRM_idOrigenCRM', (isset($movimientocrm) ? $movimientocrm->OrigenCRM_idOrigenCRM : null), array('id' => 'OrigenCRM_idOrigenCRM'))!!}
										{!!Form::text('nombreOrigenCRM',(isset($movimientocrm->OrigenCRM->nombreOrigenCRM) ? $movimientocrm->OrigenCRM->nombreOrigenCRM : 'N/A'),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif
					              	

								</div>
							</div>
						</div>
						<?php
							}
						?>
					    <div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaSolicitudMovimientoCRM', 'F. Elaboración', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-barcode"></i>
					              	</span>
									{!!Form::text('fechaSolicitudMovimientoCRM',(isset($movimientocrm) ? $movimientocrm->fechaSolicitudMovimientoCRM : $fechahora),['readonly'=>'readonly', 'class'=>'form-control','placeholder'=>'Ingresa la fecha de Elaboración'])!!}
								</div>
							</div>
						</div>
						<?php 
							if(strpos($camposVista, 'fechaEstimadaSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaEstimadaSolucionMovimientoCRM', 'Estimada', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-barcode"></i>
					              	</span>
									{!!Form::text('fechaEstimadaSolucionMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha Estimada de Solución', mostrarCampo($arrayCampos, 'fechaEstimadaSolucionMovimientoCRM', $rolUsuario,'input')])!!}
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$('#fechaEstimadaSolucionMovimientoCRM').datetimepicker(({
								defaultDate: new Date(),
    							format:'YYYY-MM-DD HH:mm'
							}));
						</script>
						<?php
							}

							if(strpos($camposVista, 'fechaVencimientoMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaVencimientoMovimientoCRM', 'F. Vencimiento', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('fechaVencimientoMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la Fecha de Vencimiento', mostrarCampo($arrayCampos, 'fechaVencimientoMovimientoCRM', $rolUsuario,'input')])!!}
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$('#fechaVencimientoMovimientoCRM').datetimepicker(({
								defaultDate: new Date(),
    							format:'YYYY-MM-DD HH:mm'
							}));
						</script>
						<?php
							}

							if(strpos($camposVista, 'fechaRealSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaRealSolucionMovimientoCRM', 'F. Real Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('fechaRealSolucionMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la Fecha Real de Solución', 'readonly'=>'readonly', mostrarCampo($arrayCampos, 'fechaRealSolucionMovimientoCRM', $rolUsuario,'input')])!!}
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'diasRealesSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('diasRealesSolucionMovimientoCRM', 'Días Reales Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('diasRealesSolucionMovimientoCRM',null,['readonly'=>'readonly', 'class'=>'form-control','placeholder'=>'Ingresa los días reales de solución'])!!}
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'prioridadMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('prioridadMovimientoCRM', 'Prioridad', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'prioridadMovimientoCRM', $rolUsuario,'select') == '')
					              		{!!Form::select('prioridadMovimientoCRM',['Alta'=>'Alta','Media'=>'Media','Baja'=>'Baja'], (isset($movimientocrm) ? $movimientocrm->prioridadMovimientoCRM : 'Baja'),["class" => "chosen-select form-control"])!!}
					              	@else
					        			{!!Form::hidden('prioridadMovimientoCRM', (isset($movimientocrm) ? $movimientocrm->prioridadMovimientoCRM : null), array('id' => 'prioridadMovimientoCRM'))!!}
										{!!Form::text('nombrePrioridadCRM',(isset($movimientocrm) ? $movimientocrm->prioridadMovimientoCRM : 'N/A'),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif
					              	

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idSolicitante') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idSolicitante', 'Solicitante', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'Tercero_idSolicitante', $rolUsuario,'select') == '')
					              		{!!Form::select('Tercero_idSolicitante',$solicitante, (isset($movimientocrm) ? $movimientocrm->Tercero_idSolicitante : $tercero['idTercero']),["class" => "chosen-select form-control"])!!}
					              	@else
					        			{!!Form::hidden('Tercero_idSolicitante', (isset($movimientocrm) ? $movimientocrm->Tercero_idSolicitante : $tercero['idTercero']), array('id' => 'Tercero_idSolicitante'))!!}
										{!!Form::text('nombreSolicitante',(isset($movimientocrm->TerceroSolicitante->nombreCompletoTercero) ? $movimientocrm->TerceroSolicitante->nombreCompletoTercero : $tercero['nombreCompletoTercero']),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif

				              	

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idProveedor') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idProveedor', 'Proveedor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'Tercero_idProveedor', $rolUsuario,'select') == '')
					              		{!!Form::select('Tercero_idProveedor',$proveedor, (isset($movimientocrm) ? $movimientocrm->Tercero_idProveedor : $tercero['idTercero']),["class" => "chosen-select form-control", 'placeholder' =>'Seleccione'])!!}
					              	@else
					        			{!!Form::hidden('Tercero_idProveedor', (isset($movimientocrm) ? $movimientocrm->Tercero_idProveedor : $tercero['idTercero']), array('id' => 'Tercero_idProveedor'))!!}
										{!!Form::text('nombreTercero',(isset($movimientocrm->Tercero_idProveedor->nombreCompletoTercero) ? $movimientocrm->Tercero_idProveedor->nombreCompletoTercero : $tercero['nombreCompletoTercero']),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif

				              	

								</div>
							</div>
						</div>

						<?php
							}

							
							if(strpos($camposVista, 'CategoriaCRM_idCategoriaCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('CategoriaCRM_idCategoriaCRM', 'Categoría', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'CategoriaCRM_idCategoriaCRM', $rolUsuario,'select') == '')
					              		{!!Form::select('CategoriaCRM_idCategoriaCRM',$categoria, (isset($movimientocrm) ? $movimientocrm->CategoriaCRM_idCategoriaCRM : null),["class" => "chosen-select form-control"])!!}
					              	@else
					        			{!!Form::hidden('CategoriaCRM_idCategoriaCRM', (isset($movimientocrm) ? $movimientocrm->CategoriaCRM_idCategoriaCRM : null), array('id' => 'CategoriaCRM_idCategoriaCRM'))!!}
										{!!Form::text('nombreCategoriaCRM',(isset($movimientocrm->CategoriaCRM->nombreCategoriaCRM) ? $movimientocrm->CategoriaCRM->nombreCategoriaCRM : 'N/A'),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif

					              	

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'EventoCRM_idEventoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('EventoCRM_idEventoCRM', 'Evento / Campaña', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'EventoCRM_idEventoCRM', $rolUsuario,'select') == '')
					              		{!!Form::select('EventoCRM_idEventoCRM',$evento, (isset($movimientocrm) ? $movimientocrm->EventoCRM_idEventoCRM : null),["class" => "chosen-select form-control"])!!}
					              	@else
					        			{!!Form::hidden('EventoCRM_idEventoCRM', (isset($movimientocrm) ? $movimientocrm->EventoCRM_idEventoCRM : null), array('id' => 'EventoCRM_idEventoCRM'))!!}
										{!!Form::text('nombreEventoCRM',(isset($movimientocrm->EventoCRM->nombreEventoCRM) ? $movimientocrm->EventoCRM->nombreEventoCRM : 'N/A'),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif
					              	

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'LineaNegocio_idLineaNegocio') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('LineaNegocio_idLineaNegocio', 'Línea de Negocio', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'LineaNegocio_idLineaNegocio', $rolUsuario,'select') == '')
					              		{!!Form::select('LineaNegocio_idLineaNegocio',$lineanegocio, (isset($movimientocrm) ? $movimientocrm->LineaNegocio_idLineaNegocio : null),["class" => "chosen-select form-control"])!!}
					              	@else
					        			{!!Form::hidden('LineaNegocio_idLineaNegocio', (isset($movimientocrm) ? $movimientocrm->LineaNegocio_idLineaNegocio : null), array('id' => 'LineaNegocio_idLineaNegocio'))!!}
										{!!Form::text('nombreLineaNegocio',(isset($movimientocrm->LineaNegocio->nombreLineaNegocio) ? $movimientocrm->LineaNegocio->nombreLineaNegocio : 'N/A'),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif
					              	

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'valorMovimientoCRM') !== false)
							{ 
								
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('valorMovimientoCRM', 'Valor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					         		<!-- Se agrega un onchange para que ejecute la funcion -->
									{!!Form::text('valorMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el valor del documento',"onchange"=>"valorDecimal(this.value);", mostrarCampo($arrayCampos, 'valorMovimientoCRM', $rolUsuario,'input')])!!}

								</div>
							</div>
						</div>
						
						<?php
							}

							if(strpos($camposVista, 'EstadoCRM_idEstadoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('EstadoCRM_idEstadoCRM', 'Estado', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	@if(mostrarCampo($arrayCampos, 'EstadoCRM_idEstadoCRM', $rolUsuario,'select') == '')
					              		{!!Form::select('EstadoCRM_idEstadoCRM',$estado, (isset($movimientocrm) ? $movimientocrm->EstadoCRM_idEstadoCRM : null),["class" => "chosen-select form-control"])!!}
					              	@else

					        			{!!Form::hidden('EstadoCRM_idEstadoCRM', (isset($movimientocrm) ? $movimientocrm->EstadoCRM_idEstadoCRM : $idEstadoDefault), array('id' => 'EstadoCRM_idEstadoCRM'))!!}
										{!!Form::text('nombreEstadoCRM',(isset($movimientocrm->EstadoCRM->nombreEstadoCRM) ? $movimientocrm->EstadoCRM->nombreEstadoCRM : $nombreEstadoDefault),['readonly'=>'readonly', 'class'=>'form-control'])!!}
									@endif
					              	

								</div>
							</div>
						</div>
						
						<?php
							}
						?>

						<div class="col-sm-12">
						<ul class="nav nav-tabs">
						<?php

						if(strpos($camposVista, 'detallesMovimientoCRM') !== false)
						{ 
						?>
							<li class="active"><a data-toggle="tab" href="#detalles">Detalles</a></li>

						<?php
						}
						
						if(strpos($camposVista, 'solucionMovimientoCRM') !== false)
						{ 
						?>
							<li><a data-toggle="tab" href="#solucion">Solución</a></li>
						<?php
						}

						if(strpos($camposVista, 'asistentesMovimientoCRM') !== false)
						{ 
						?>
					  		<li><a data-toggle="tab" href="#asistentes">Asistentes</a></li>
						<?php
						}

						if(strpos($camposVista, 'documentosMovimientoCRM') !== false)
						{ 
						?>
					  		<li><a data-toggle="tab" href="#documentos">Documentos</a></li>
						<?php
						}
						if(strpos($camposVista, 'vacantesMovimientoCRM') !== false)
						{
							?>
					  		<li><a data-toggle="tab" href="#vacantes">Vacantes</a></li>
					  		<?php
						}
						if(strpos($camposVista, 'tareasMovimientoCRM') !== false)
						{
							?>
					  		<li><a data-toggle="tab" href="#tareas">Tareas</a></li>
					  		<?php
						}
						if(strpos($camposVista, 'productoServicioMovimientoCRM') !== false)
						{
							?>
					  		<li><a data-toggle="tab" href="#productoservicio">Productos o Servicios</a></li>
					  		<?php
						}
						?>
					</ul>
					</div>

					<div class="tab-content">
					<?php
						if(strpos($camposVista, 'detallesMovimientoCRM') !== false)
						{ 
					?>
					  <div id="detalles" class="tab-pane fade in active">
					    <div class="col-sm-12">
							<div class="panel panel-primary">
					            <div class="panel-heading">
					                <i class="fa fa-pencil-square-o"></i> {!!Form::label('detallesMovimientoCRM', 'Detalles', array())!!}
					            </div>
					            <div class="panel-body">
					                
									<div class="col-sm-12">
							              {!!Form::textarea('detallesMovimientoCRM',null,['class'=>'ckeditor','placeholder'=>'Ingresa los detalles del documento', mostrarCampo($arrayCampos, 'detallesMovimientoCRM', $rolUsuario,'select')])!!}
									</div>

					            </div>
					        </div>
						</div>
					  </div>
					<?php
						}
					
						if(strpos($camposVista, 'solucionMovimientoCRM') !== false)
						{ 
					?>
					  <div id="solucion" class="tab-pane fade">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('solucionMovimientoCRM', 'Solución', array())!!}
                                </div>
                                <div class="panel-body">
                                    
									<div class="col-sm-12">
							              {!!Form::textarea('solucionMovimientoCRM',null,['class'=>'ckeditor','placeholder'=>'Ingresa la solución del documento', mostrarCampo($arrayCampos, 'solucionMovimientoCRM', $rolUsuario,'select')])!!}
									</div>

                                </div>
                            </div>
						</div>
					</div>
					<?php
						}
					if(strpos($camposVista, 'asistentesMovimientoCRM') !== false)
						{ 
					?>
					  <div id="asistentes" class="tab-pane fade">
					    <div class="panel-body">
							<div class="form-group" id='test'>
								<div class="col-sm-12">
									<div class="row show-grid">
										<div class="col-md-1" style="width: 40px;height:35px;" onclick="asistentes.agregarCampos(valorAsistentes,'A')">
											<span class="glyphicon glyphicon-plus"></span>
										</div>
										<div class="col-md-1" style="width: 330px;height:35px;">Nombre</div>
										<div class="col-md-1" style="width: 270px;height:35px;">Cargo</div>
										<div class="col-md-1" style="width: 150px;height:35px;">Tel&eacute;fono</div>
										<div class="col-md-1" style="width: 230px;height:35px;">Correo</div>
										<div id="contenedor_asistentes">
										</div>
									</div>
								</div>
							</div>
						</div>

					  </div>
					<?php
						}
					if(strpos($camposVista, 'documentosMovimientoCRM') !== false)
						{ 
					?>
					  <div id="documentos" class="tab-pane fade">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('', 'Documentos', array())!!}
                                </div>
                                <div class="panel-body">
									<div class="col-sm-12">
										<div id="upload" class="col-md-12">
										    <div class="dropzone dropzone-previews" id="dropzonemovimientoCRMArchivo" style="overflow: auto">
										    </div>  
										</div>	
 									
										
										<div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;overflow: auto;">		
										{!!Form::hidden('archivoMovimientoCRMArray', '', array('id' => 'archivoMovimientoCRMArray'))!!}
											<?php
											if ($idMovimientoCRMA != '') 
											{
												$eliminar = '';
												$archivoSave = DB::Select('SELECT * from movimientocrmarchivo where MovimientoCRM_idMovimientoCRM = '.$idMovimientoCRMA);

												for ($i=0; $i <count($archivoSave) ; $i++) 
												{ 
													$archivoS = get_object_vars($archivoSave[$i]);

													echo '<div id="'.$archivoS['idMovimientoCRMArchivo'].'" class="col-lg-4 col-md-4">
									                    <div class="panel panel-yellow" style="border: 1px solid orange;">
									                        <div class="panel-heading">
									                            <div class="row">
									                                <div class="col-xs-3">
									                                    <a target="_blank" 
									                                    	href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaMovimientoCRMArchivo'].'">
									                                    	<i class="fa fa-book fa-5x" style="color: gray;"></i>
									                                    </a>
									                                </div>
									                                <div class="col-xs-9 text-right">
									                                    <div>'.str_replace('/movimientocrm/','',$archivoS['rutaMovimientoCRMArchivo']).'
									                                    </div>
									                                </div>
									                            </div>
									                        </div>
									                        <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idMovimientoCRMArchivo'].');">
									                            <div class="panel-footer">
									                                <span class="pull-left">Eliminar Documento</span>
									                                <span class="pull-right"><i class="fa fa-times"></i></span>
									                                <div class="clearfix"></div>
									                            </div>
									                        </a>
									                    </div>
									                </div>';

													echo '<input type="hidden" id="idMovimientoCRMArchivo[]" name="idMovimientoCRMArchivo[]" value="'.$archivoS['idMovimientoCRMArchivo'].'" >

													<input type="hidden" id="rutaMovimientoCRMArchivo[]" name="rutaMovimientoCRMArchivo[]" value="'.$archivoS['rutaMovimientoCRMArchivo'].'" >';
												}

												echo '<input type="hidden" name="eliminarArchivo" id="eliminarArchivo" value="">';
											}
											
											 ?>							
										</div>
									</div>
								</div>
							</div>
						</div>
					  </div>
					 <?php
						}
							if(strpos($camposVista, 'vacantesMovimientoCRM') !== false)
						{ 
						?>
					  <div id="vacantes" class="tab-pane fade">
						   <div class="form-group" id='test'>
			                    <div class="col-sm-12">

			                      	<div class="row show-grid">
			                        <div class="col-md-1" style="width: 40px;height: 35px;" onclick="abrirModalVacante();">
			                          <span class="glyphicon glyphicon-plus"></span>
			                        </div>
			                        <div class="col-md-1" style="width: 230px;display:inline-block;height:35px;">Cargo</div>
			                        <div class="col-md-1" style="width: 230px;display:inline-block;height:35px;">No.Vacantes</div>
			                        <div class="col-md-1" style="width: 230px;display:inline-block;height:35px;">Salario</div>
			                        <div class="col-md-1" style="width: 230px;display:inline-block;height:35px;">Fecha Est.Vinculación</div>
			                          

			                        <!-- este es el div para donde van insertando los registros --> 
			                        <div id="documentocrmcargo_Modulo">
			                        </div>
			                      </div>
		                    	</div>
	               		 </div>  
              		 </div>

					<?php
					}
					if(strpos($camposVista, 'tareasMovimientoCRM') !== false)
					{ 
					?>
					<div id="tareas" class="tab-pane fade">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('', 'Tareas', array())!!}
                                </div>
                                <div class="panel-body">
									<div class="col-sm-12">

									<div class="col-sm-6">
										<div class="col-sm-12">
											{!!Form::label('fechaHoraInicioAgenda', 'Fecha de Inicio', array())!!}
										</div>
										<div class="col-sm-12">
								            <div class="input-group">
								              	<span class="input-group-addon">
								                	<i class="fa fa-calendar"></i>
								              	</span>
												{!!Form::text('fechaHoraInicioAgenda',(isset($movimientoCRMTarea) and !empty($movimientoCRMTarea)) ? $camposAgendaTarea[0]['fechaInicioAgendaTarea'] : null,['class'=>'form-control','placeholder'=>'Ingresa la fecha de inicio'])!!}
											</div>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="col-sm-12">
											{!!Form::label('horasDiaAgenda', 'Horas al día', array())!!}
										</div>
										<div class="col-sm-12">
								            <div class="input-group">
								              	<span class="input-group-addon">
								                	<i class="fa fa-clock-o"></i>
								              	</span>
												{!!Form::text('horasDiaAgenda',(isset($movimientoCRMTarea) and !empty($movimientoCRMTarea)) ? $camposAgendaTarea[0]['horasAgendaTarea'] : null,['class'=>'form-control','placeholder'=>'Horas al día a trabajar'])!!}
											</div>
										</div>
									</div>

									<br><br><br><br>
										
									<div class="row show-grid">
									  <div style="width: 1052px; display: inline-block; ">
						              <div class="col-md-1" style="width: 542px;">&nbsp;</div>
						              <div class="col-md-1" onclick="calcularHoras()" style="width: 80px; height: 42px; cursor:pointer;">
						              <center><span class="glyphicon glyphicon-refresh"></span></center></div>
						              <div class="col-md-1" style="width: 430px;">&nbsp;</div>
			                        <div class="col-md-1" style="width: 42px;height: 42px; cursor:pointer;" onclick="abrirModalEvento()">
			                          <span class="glyphicon glyphicon-plus"></span>
			                        </div>
			                        <div class="col-md-1" style="width: 120px;">Categoria</div>
			                        <div class="col-md-1" style="width: 120px;">Descripción</div>
			                        <div class="col-md-1" style="width: 100px;">Ubicación</div>
			                        <div class="col-md-1" style="width: 80px;">Inicio</div>
			                        <div class="col-md-1" style="width: 80px;">Fin</div>
			                        <div class="col-md-1" style="width: 80px;">Horas</div>
			                        <div class="col-md-1" style="width: 150px;">Responsable</div>
			                        <div class="col-md-1" style="width: 80px;">%Peso</div>
			                        <div class="col-md-1" style="width: 100px;">%Ejecucion</div>
			                        <div class="col-md-1" style="width: 100px;">Estado</div>

			                        <!-- este es el div para donde van insertando los registros --> 
			                        <div id="contenedor_tareas">
			                        </div>
			                        </div>
			                      </div>

			                      	<div class="col-sm-12">
										<div class="col-sm-2">
											{!!Form::label('fechaHoraEstimadaFinAgenda', 'Fecha estimada fin', array())!!}
										</div>
										<div class="col-sm-4">
								            <div class="input-group">
								              	<span class="input-group-addon">
								                	<i class="fa fa-calendar"></i>
								              	</span>
												{!!Form::text('fechaHoraEstimadaFinAgenda',null,['class'=>'form-control','placeholder'=>'Fecha estimada de fin', 'readonly'])!!}
											</div>
										</div>
									</div>

									<div class="col-sm-12">
										<div class="col-sm-2">
											{!!Form::label('tiempoTotalAgendaTarea', 'Tiempo total', array())!!}
										</div>
										<div class="col-sm-4">
								            <div class="input-group">
								              	<span class="input-group-addon">
								                	<i class="fa fa-clock-o"></i>
								              	</span>
												{!!Form::text('tiempoTotalAgendaTarea',null,['class'=>'form-control','placeholder'=>'Tiempo total', 'readonly'])!!}
											</div>
										</div>
									</div>

									<div class="col-sm-12">
										<div class="col-sm-2">
											{!!Form::label('porcentajeCumplimientoAgendaTarea', 'Porcentaje cumplimiento', array())!!}
										</div>
										<div class="col-sm-4">
								            <div class="input-group">
								              	<span class="input-group-addon">
								                	<i>%</i>
								              	</span>
												{!!Form::text('porcentajeCumplimientoAgendaTarea',null,['class'=>'form-control','placeholder'=>'Porcentade de cumplimiento'])!!}
											</div>
										</div>
									</div>

									{!!Form::hidden('eliminarAgendaTarea', null, array('id' => 'eliminarAgendaTarea'))!!}
 									
									</div>
								</div>
							</div>
						</div>
					  </div>
					<?php
						}
							if(strpos($camposVista, 'productoServicioMovimientoCRM') !== false)
						{ 
						?>
					  	<div id="productoservicio" class="tab-pane fade">
						   	<div class="form-group" id='test'>
			                    <div class="col-sm-12">
			                      	<div class="row show-grid">
			                        <div class="col-md-1" style="width: 40px;height: 35px; cursor: pointer;" onclick="abrirModalFichaTecnica();">
			                          <span class="glyphicon glyphicon-plus"></span>
			                        </div>
			                        <div class="col-md-1" style="width: 200px;display:inline-block;height:35px;">Referencia</div>
			                        <div class="col-md-1" style="width: 400px;display:inline-block;height:35px;">Descripción</div>
			                        <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">Cantidad</div>
			                        <div class="col-md-1" style="width: 150px;display:inline-block;height:35px;">Valor Unitario</div>
			                        <div class="col-md-1" style="width: 150px;display:inline-block;height:35px;">Valor Total</div>
			                          
			                        <!-- este es el div para donde van insertando los registros --> 
			                        <div id="contenedor_productoservicio">
			                        </div>
			                      </div>
		                    	</div>
	               		 	</div>  

	               		 	<div class="form-group col-md-12" id='test' style="display:inline-block">
		                      {!!Form::label('totalProducto', 'Valor Total Productos: ', array('class' => 'col-sm-2 control-label')) !!}
		                      <div class="col-md-8">
		                        <div class="input-group">
		                          <span class="input-group-addon">
		                            <i class="fa fa-dollar"></i>
		                          </span>
		                          {!!Form::text('totalProducto',null,['class'=>'form-control','readonly', 'placeholder'=>''])!!}
		                        </div>
		                      </div>
		                    </div>
		                    {!!Form::hidden('eliminarMovimientoCRMPRoducto', null, array('id' => 'eliminarMovimientoCRMPRoducto'))!!}
              		 	</div>
					<?php
					}
					?>
					</div>
					
					</div>

				    </div>	

				</fieldset>	
				@if(isset($movimientocrm))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script>
    CKEDITOR.replace((<?php
     echo (strpos($camposVista, 'detallesMovimientoCRM') !== false) ? "'".'detallesMovimientoCRM'."'" : '';
     echo ((strpos($camposVista, 'detallesMovimientoCRM') !== false and strpos($camposVista, 'solucionMovimientoCRM') !== false)) ? "," : '';
     echo (strpos($camposVista, 'solucionMovimientoCRM') !== false) ? "'".'solucionMovimientoCRM'."'" : '';
     ?>), {
        fullPage: true,
        allowedContent: true
      });  


    //--------------------------------- DROPZONE ---------------------------------------
	var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzonemovimientoCRMArchivo", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

   	 fileList = Array();
   	var i = 0;

    //Configuro el dropzone
    myDropzone.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    accept: function(file, done) {

      }
    };
    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('archivoMovimientoCRMArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
    					//abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
						// console.log(fileList);
                        document.getElementById('archivoMovimientoCRMArray').value += file.name+',';
                        // console.log(document.getElementById('archivoMovimientoCRMArray').value);
                        i++;
                    });

</script>

@stop

<!-- Grid modal para  cargo (Vacantes) -->
<div id="ModalVacante" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Seleccion Vacantes</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="campos" name="campos" src="http://'.$_SERVER["HTTP_HOST"].'/MovimientocrmVacantegridselect"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>

<div id="modalEvento" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crear una nueva tarea</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="eventos" name="eventos" src="http://'.$_SERVER["HTTP_HOST"].'/eventoagenda?crear=crear"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>

<div id="modalFichaTecnica" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ficha técnica</h4>
      </div>
      <div class="modal-body">
      	<div class="container">
            <div class="row" style="width:90%;">
                <div class="container" style="width:100%;">
                    <table id="tfichatecnica" name="tfichatecnica" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>Referencia</b></th>
                                <th><b>Descripción</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>Referencia</th>
                                <th>Descripción</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal-footer">
                        <button id="botonFichaTecnica" name="botonFichaTecnica" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>
				</div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>