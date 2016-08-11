<?php

    $id = isset($_GET["idDocumento"])
                ? $_GET["idDocumento"] 
                : 0;

    $camposGrid = isset($_GET["camposGrid"])
                ? $_GET["camposGrid"] 
                : 'idMovimientoCRM,numeroMovimientoCRM,asuntoMovimientoCRM';

    $camposBase = isset($_GET["camposBase"])
                ? $_GET["camposBase"] 
                : 'idMovimientoCRM,numeroMovimientoCRM,asuntoMovimientoCRM';

    $movimientocrm = DB::select(
        'Select
          '.$camposGrid.'
        From
          movimientocrm 
          left join documentocrm
          On movimientocrm.DocumentoCRM_idDocumentoCRM = documentocrm.idDocumentoCRM
          Left Join tercero solicitante
            On movimientocrm.Tercero_idSolicitante = solicitante.idTercero 
          Left Join tercero supervisor
            On movimientocrm.Tercero_idSupervisor = supervisor.idTercero 
          Left Join tercero asesor
            On movimientocrm.Tercero_idAsesor = asesor.idTercero 
          Left Join categoriacrm
            On movimientocrm.CategoriaCRM_idCategoriaCRM = categoriacrm.idCategoriaCRM
          Left Join lineanegocio
            On movimientocrm.LineaNegocio_idLineaNegocio = lineanegocio.idLineaNegocio
          Left Join origencrm
            On movimientocrm.OrigenCRM_idOrigenCRM = origencrm.idOrigenCRM 
          Left Join estadocrm
            On movimientocrm.EstadoCRM_idEstadoCRM = estadocrm.idEstadoCRM 
          Left Join acuerdoservicio
            On movimientocrm.AcuerdoServicio_idAcuerdoServicio =
            acuerdoservicio.idAcuerdoServicio
        Where idDocumentoCRM = '.$id);


    $row = array();

    for($i = 0; $i < count($movimientocrm); $i++)
    {  
        $datoValor = get_object_vars($movimientocrm[$i]); 
        $row[$i][] = '<a href="movimientocrm/'.$datoValor["idMovimientoCRM"].'/edit?idDocumentoCRM='.$id.'">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="movimientocrm/'.$datoValor["idMovimientoCRM"].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';

        $campos = explode(',', $camposBase);
        for($j = 0; $j < count($campos); $j++)
        {
            $row[$i][] = $datoValor[trim($campos[$j])];
        }

    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>