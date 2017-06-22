<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];

    $visibleM = '';
    $visibleE = '';
    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';



    $actoinseguro = DB::SELECT('
        SELECT actin.idActoInseguro,ter.nombreCompletoTercero as EmpleadoReporta,actin.fechaElaboracionActoInseguro,actin.estadoActoInseguro,actin.fechaSolucionActoInseguro,tes.nombreCompletoTercero as EmpleadoSoluciona
          FROM actoinseguro actin
          LEFT JOIN tercero ter
          ON ter.idTercero = actin.Tercero_idEmpleadoReporta
          LEFT JOIN tercero tes
          ON tes.idTercero = actin.Tercero_idEmpleadoSoluciona
          WHERE actin.Compania_idCompania = '.\Session::get('idCompania'));
    $row = array();

    foreach ($actoinseguro as $key => $value) 
    {  
        $actoinseguroC = get_object_vars($value);
        $row[$key][] = '<a href="actoinseguro/'.$actoinseguroC['idActoInseguro'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"  style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="actoinseguro/'.$actoinseguroC['idActoInseguro'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp';
        $row[$key][] = $actoinseguroC['idActoInseguro'];
        $row[$key][] = $actoinseguroC['EmpleadoReporta'];
        $row[$key][] = ($actoinseguroC['fechaElaboracionActoInseguro'] == '0000-00-00' ? "" : $actoinseguroC['fechaElaboracionActoInseguro']);
        $row[$key][] = ($actoinseguroC['estadoActoInseguro'] == 'PLANACCION' ? "En Plan de Accion" : $actoinseguroC['estadoActoInseguro']);    
         // En la salida de la informacion se hace una condicion de que si tiene en 000-000  o no esta diligenciado el campo ,la fecha de ingreso mostrara en la grid el campo vacio.
        $row[$key][] = ($actoinseguroC['fechaSolucionActoInseguro'] == '0000-00-00' ? "" : $actoinseguroC['fechaSolucionActoInseguro']);
        $row[$key][] = $actoinseguroC['EmpleadoSoluciona'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>