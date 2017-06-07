<?php 

$id = $_GET['idFichaTecnica'];

$proceso = DB::select(
            'SELECT ordenFichaTecnicaProceso,
                    Proceso_idProceso,
                    nombreProceso,
                    observacionFichaTecnicaProceso
            FROM fichatecnicaproceso FTP
            LEFT JOIN proceso P 
            ON FTP.Proceso_idProceso = P.idProceso
            WHERE FichaTecnica_idFichaTecnica = '.$id);

//print_r($consulta);

echo json_encode($proceso);
?>


