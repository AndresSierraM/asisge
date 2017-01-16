<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $consultar = $_GET['consultar'];
    $aprobar = $_GET['aprobar'];

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

    if ($consultar == 1) 
        $visibleC = 'inline-block;';
    else
        $visibleC = 'none;';

    if ($aprobar == 1) 
        $visibleA = 'inline-block;';
    else
        $visibleA = 'none;';



    $id = isset($_GET["idDocumento"])
                ? $_GET["idDocumento"] 
                : 0;

    $TipoEstado = isset($_GET["TipoEstado"])
                ? $_GET["TipoEstado"] 
                : 'Nuevo';

    $campos = DB::select(
    'SELECT codigoDocumentoCRM, nombreDocumentoCRM, nombreCampoCRM,descripcionCampoCRM, 
            mostrarGridDocumentoCRMCampo, relacionTablaCampoCRM, relacionNombreCampoCRM, relacionAliasCampoCRM
    FROM documentocrm
    left join documentocrmcampo
    on documentocrm.idDocumentoCRM = documentocrmcampo.DocumentoCRM_idDocumentoCRM
    left join campocrm
    on documentocrmcampo.CampoCRM_idCampoCRM = campocrm.idCampoCRM
    where   documentocrm.idDocumentoCRM = '.$id.' and
            relacionTablaCampoCRM != "" and 
            mostrarGridDocumentoCRMCampo = 1');

$camposGrid = 'idMovimientoCRM, numeroMovimientoCRM, asuntoMovimientoCRM, DATEDIFF(CURDATE(), fechaSolicitudMovimientoCRM) as diasProceso';
$camposBase = 'idMovimientoCRM,numeroMovimientoCRM,asuntoMovimientoCRM, diasProceso';
for($i = 0; $i < count($campos); $i++)
{
    $datos = get_object_vars($campos[$i]); 
    
    $camposGrid .= ', '. $datos["relacionTablaCampoCRM"].'.'.$datos["relacionNombreCampoCRM"]  .
                     ($datos["relacionAliasCampoCRM"] == null 
                        ? ''
                        : ' As '. $datos["relacionAliasCampoCRM"]);

    $camposBase .= ','.($datos["relacionAliasCampoCRM"] == null 
                        ? $datos["relacionNombreCampoCRM"]
                        : $datos["relacionAliasCampoCRM"]);

}

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
          Left Join eventocrm
            On movimientocrm.EventoCRM_idEventoCRM = eventocrm.idEventoCRM 
          Left Join acuerdoservicio
            On movimientocrm.AcuerdoServicio_idAcuerdoServicio =
            acuerdoservicio.idAcuerdoServicio
        Where   idDocumentoCRM = '.$id.  ' and 
                movimientocrm.Compania_idCompania = '.\Session::get('idCompania'). ' and 
                (movimientocrm.Tercero_idSolicitante = '.\Session::get('idTercero'). ' or 
                 movimientocrm.Tercero_idSupervisor = '.\Session::get('idTercero'). ' or 
                 movimientocrm.Tercero_idAsesor = '.\Session::get('idTercero'). ') '. 
                ($TipoEstado != '' ? ' and estadocrm.tipoEstadoCRM = "'.$TipoEstado.'"' : '').
        ' Order By numeroMovimientoCRM DESC ' );


    $row = array();

    for($i = 0; $i < count($movimientocrm); $i++)
    {  
        $datoValor = get_object_vars($movimientocrm[$i]); 
        $row[$i][] = '<a href="movimientocrm/'.$datoValor["idMovimientoCRM"].'/edit?idDocumentoCRM='.$id.'">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="movimientocrm/'.$datoValor["idMovimientoCRM"].'/edit?idDocumentoCRM='.$id.'&accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="javascript:mostrarModalAsesor('.$datoValor["idMovimientoCRM"].');">'.
                            '<span class="glyphicon glyphicon-check" style = "display:'.$visibleA.'" ></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$datoValor["idMovimientoCRM"].','.$id.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleC.'" ></span>'.
                        '</a>';

        $campos = explode(',', $camposBase);
        for($j = 0; $j < count($campos); $j++)
        {
          // if(trim($campos[$j]) == 'asuntoMovimientoCRM')
          //     $row[$i][] = '<p title="'.$datoValor['detallesMovimientoCRM'].'">'.$datoValor[trim($campos[$j])].'</p>';
          // else
              $row[$i][] = $datoValor[trim($campos[$j])];
          
        }

    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>