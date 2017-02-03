<?php 

$condicion = $_POST['condicion'];

$consulta = DB::Select('
	SELECT idEntrevista,e.Cargo_idCargo,e.Tercero_idEntrevistador,fechaEntrevista,c.porcentajeEducacionCargo,c.porcentajeExperienciaCargo,c.porcentajeFormacionCargo,c.porcentajeResponsabilidadCargo,c.porcentajeHabilidadCargo,Competencia_idCompetencia,nombre1AspiranteEntrevista,nombre2AspiranteEntrevista,apellido1AspiranteEntrevista,apellido2AspiranteEntrevista,t.nombreCompletoTercero
	FROM entrevista e
	Left Join cargo c
	On e.Cargo_idCargo = c.idCargo
	left join cargocompetencia cc
	On cc.Cargo_idCargo = c.idCargo
	left join tercero t
	On e.Tercero_idEntrevistador = t.idTercero 
	WHERE '.$condicion);



$informehtml = '';


 $informehtml .=   '<div class="container">                                       
  <table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
</thead>
    <thead>  ';
     for ($i=0; $i <count($consulta) ; $i++) 
    { 
    	$datosconsulta = get_object_vars($consulta[$i]);

 		$informehtml .= '
      <tr>

      	<td colspan="2"></td>
	  		<td>'.$datosconsulta['porcentajeExperienciaCargo'].'%'.'</td> 
	        <td>'.$datosconsulta['porcentajeEducacionCargo'].'%'.'</td> 
	        <td>'.$datosconsulta['porcentajeFormacionCargo'].'%'.'</td>
	        <td>Anterior Competencia</td>
	        <td>'.$datosconsulta['porcentajeHabilidadCargo'].'%'.'</td>
	        <td>'.$datosconsulta['porcentajeResponsabilidadCargo'].'%'.'</td>


      </tr>
      ';
     }
$informehtml .= '
      <tr>
        <th>Nombre Entrevistador</th>
        <th>Aspirante</th>
        <th>Experiencia</th>
        <th>Educacion</th>
        <th>Formación</th>
		<th>Habilidades Actitudinales</th>
		<th>Habilidades propias del Cargo</th>
		<th>Responsabilidades</th>
        <th>Resultado(%)</th>
		<th>Concepto del Entrevistador</th>
		<th>Estado Final</th>
      </tr>
    
    </thead>
    <tbody>
    
    ';

    for ($i=0; $i <count($consulta) ; $i++) 
    { 
    	$datosconsulta = get_object_vars($consulta[$i]);

    

    	$informehtml .= '
      <tr background-color:#EEEEEE;>
	        <td>'.$datosconsulta['nombreCompletoTercero'].'</td>
	        <td>'.$datosconsulta['nombre1AspiranteEntrevista'].' '.$datosconsulta['nombre2AspiranteEntrevista'].' '.$datosconsulta['apellido1AspiranteEntrevista'].' '.$datosconsulta['apellido2AspiranteEntrevista'].'</td>
	        <td></td>
			<td></td>
	        <td></td>
			<td></td>
			<td></td>
	        <td></td>
			
	        <td></td>
	        <td> <textarea id="observacionInformeEntrevista"></textarea></td>
	        <input type="hidden" id="idEntrevista" value ="'.$datosconsulta["idEntrevista"].'" name="idEntrevista">
	        
	        <td>';?> {!! Form::select('idEntrevista', ['EnProceso' =>'En Proceso','Seleccionado' => 'Seleccionado','Rechazado'=>'Rechazado'],null,['class' => 'form-control',"placeholder"=>"Seleccione el estado"]) !!} <?php $informehtml .='</td> 
      </tr>
			';

	}
	 		$informehtml .= '
		    </tbody>
		  	</table>
			</div>';
    
    


 echo json_encode($informehtml);

?>


