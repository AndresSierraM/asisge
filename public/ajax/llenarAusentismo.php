<?php
// Realizo una consulta trayendo el idTercero por post para poder mediante un ajax llenar el campo ausentismo
$idEmpleado = $_POST["idEmpleado"];

$ausencia = DB::table('ausentismo')
->leftjoin('accidente', 'ausentismo.idAusentismo', "=", 'accidente.Ausentismo_idAusentismo')
->select(DB::raw('idAusentismo, nombreAusentismo'))
->where ('ausentismo.Tercero_idTercero', "=", $idEmpleado)
->where ('ausentismo.tipoAusentismo', "like", "%dente%")
->whereNull('idAccidente')
->get();

//Convierto un array en string
//$ausencia = get_object_vars($cargo[0]); 
echo json_encode($ausencia); //envio los datos  mediante JSON
?>