<?php 

$idProveedor = $_POST['idProveedor'];

$resultado = DB::Select('
    SELECT 
        descripcionTipoProveedorEvaluacion, 
        pesoTipoProveedorEvaluacion 
    FROM 
        tipoproveedorevaluacion tpe 
        left join tercero t on tpe.TipoProveedor_idTipoProveedor = t.TipoProveedor_idTipoProveedor 
    WHERE 
        idTercero = '.$idProveedor);

echo json_encode($resultado)


?>