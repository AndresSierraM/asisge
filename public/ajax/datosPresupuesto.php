<?php 


$valoresPresupuesto = DB::Select('Select idPresupuesto, nombreCompletoTercero, valorLineaNegocio from presupuesto p left join presupuestodetalle pd on pd.Presupuesto_idPresupuesto = p.idPresupuesto left join tercero t on pd.Tercero_idVendedor = t.idTercero');

$row = array();

    foreach ($valoresPresupuesto as $key => $value) 
    {  
        $valorPresupuesto = get_object_vars($value);

        $row[$key][] = '<a href="presupuesto/'.$value['idPresupuesto'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="presupuesto/'.$value['idPresupuesto'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
                        
        foreach ($value as $pos => $campo) 
        {
            $row[$key][] = $campo;
        }
        
    }

$output['aaData'] = $row;
echo json_encode($output);

?>