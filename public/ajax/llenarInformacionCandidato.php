<?php 

$IdTerceroEmpleado = $_POST['IdTerceroEmpleado'];

$consulta = DB::Select('
  SELECT c.nombreCargo, cc.nombreCentroCosto,t.Cargo_idCargo,t.CentroCosto_idCentroCosto
  FROM tercero t 
  LEFT JOIN cargo c
  ON t.Cargo_idCargo = c.idCargo
  LEFT JOIN centrocosto cc
  ON t.CentroCosto_idCentroCosto = cc.idCentroCosto
  WHERE t.idTercero = '.$IdTerceroEmpleado);


//print_r($consulta);

echo json_encode($consulta);
?>



