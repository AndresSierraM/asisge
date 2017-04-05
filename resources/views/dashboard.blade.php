@extends('layouts.vista')
@section('titulo')<h1 id="titulo"><center>Dashboard</center></h1>@stop

@section('content')

{!! Html::script('chart/Chart.js'); !!}
{!! Html::script('js/dashboard.js'); !!}

<?php 
    $idCompania = \Session::get("idCompania");
    $mes = date("m");
    $anomes = date("Y-m");
?>
<!-- Token para ejecuciones de ajax -->
<input type="hidden" id="token" value="{{csrf_token()}}"/>

<div class="col-lg-12 col-md-12 PlanTrabajo" style="position: absolute; top: 30px; display: none; z-index:5;" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog" style="height: 400px;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header btn-default active" style="border-radius: 3px;">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title"><div>Detalles</div><button style="float:right; display: inline-block;" onclick="$('.PlanTrabajo').css('display', 'none');">X</button></h4>
            </div>
            <div class="modal-body" style="height:400px;">
                <div class="containerPlanTrabajo" style="width: 100%;height: 100%;overflow-y:scroll;">
                 
                </div> 
            </div>
        </div>
    </div>   
</div>

            <div class="row">
               <div class="col-lg-4 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 

                                    // -------------------------------------------
                                    //  P R O G R A M A S   /   A C T I V I D A D E S
                                    // -------------------------------------------
                                    $total = DB::select(
                                        'SELECT 
                                            SUM(1) as Tarea,
                                            SUM(IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1)) as Ejecutado
                                        From programa P
                                        left join programadetalle PD
                                        on P.idPrograma = PD.Programa_idPrograma
                                        Where   P.Compania_idCompania = '.$idCompania .' ');

                                    $dato = DB::select(
                                        'SELECT 
                                            SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = '.$mes.', 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = '.$mes.', IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as Ejecutado
                                        From programa P
                                        left join programadetalle PD
                                        on P.idPrograma = PD.Programa_idPrograma
                                        Where   (MONTH(fechaPlaneadaProgramaDetalle) = '.$mes.' or MONTH(fechaEjecucionProgramaDetalle) = '.$mes.') and 
                                                P.Compania_idCompania = '.$idCompania .' ');
                                    
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{$totales["Ejecutado"].' / '.$totales["Tarea"]}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{$datos["Ejecutado"].' / '.$datos["Tarea"]}}</div>
                                    <div >
                                    ({{number_format($datos["Ejecutado"]/($datos["Tarea"] == 0 ? 1 : $datos["Tarea"])*100,1,'.',',')}}%)</div>
                                    <div>Programas</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:consultarPlanTrabajo(<?php echo $idCompania; ?>,'dashboardConsultarProgramas', 'Plan Anual de Programas');">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 

                                    // $dato = DB::select("Select count(idActaCapacitacion) as total From actacapacitacion Where MONTH(fechaElaboracionActaCapacitacion) = ".$mes." and Compania_idCompania = ".$idCompania);

                                    // -------------------------------------------
                                    //  P L A N   D E   C A P A C I T A C I O N
                                    // -------------------------------------------
                                    $total = DB::select(
                                        'SELECT 
                                            SUM(1) as Tarea,
                                            SUM(IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1)) as Ejecutado
                                        From plancapacitacion PC
                                        left join plancapacitaciontema PCT
                                        on PC.idPlanCapacitacion = PCT.PlanCapacitacion_idPlanCapacitacion
                                        left join 
                                        (
                                            SELECT * 
                                            FROM  actacapacitaciontema ACT
                                            left join actacapacitacion AC
                                            on ACT.ActaCapacitacion_idActaCapacitacion = AC.idActaCapacitacion
                                            where AC.Compania_idCompania = '.$idCompania .' and ACT.cumpleObjetivoActaCapacitacionTema
                                        )  ACT
                                        on PC.idPlanCapacitacion = ACT.PlanCapacitacion_idPlanCapacitacion and 
                                        PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
                                        WHere  PC.Compania_idCompania = '.$idCompania );

                                    $dato = DB::select(
                                        'SELECT 
                                            SUM(IF(MONTH(fechaPlanCapacitacionTema) = '.$mes.', 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaPlanCapacitacionTema) = '.$mes.', IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as Ejecutado
                                        From plancapacitacion PC
                                        left join plancapacitaciontema PCT
                                        on PC.idPlanCapacitacion = PCT.PlanCapacitacion_idPlanCapacitacion
                                        left join 
                                        (
                                            SELECT * 
                                            FROM  actacapacitaciontema ACT
                                            left join actacapacitacion AC
                                            on ACT.ActaCapacitacion_idActaCapacitacion = AC.idActaCapacitacion
                                            where AC.Compania_idCompania = '.$idCompania .' and ACT.cumpleObjetivoActaCapacitacionTema
                                        )  ACT
                                        on 
                                            PC.idPlanCapacitacion = ACT.PlanCapacitacion_idPlanCapacitacion
                                         and 
                                        PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
                                        WHere  MONTH(fechaPlanCapacitacionTema) = '.$mes.' and 
                                                PC.Compania_idCompania = '.$idCompania );
                                    
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{$totales["Ejecutado"].' / '.$totales["Tarea"]}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{$datos["Ejecutado"].' / '.$datos["Tarea"]}}</div>
                                    <div >
                                    ({{number_format($datos["Ejecutado"]/($datos["Tarea"] == 0 ? 1 : $datos["Tarea"])*100,1,'.',',')}}%)</div>
                                    <div>Capacitaciones</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:consultarPlanTrabajo(<?php echo $idCompania; ?>,'dashboardConsultarCapacitaciones','Plan Anual de Capacitaciones');">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    // -------------------------------------------
                                    //  I N S P E C C I O N E S   D E   S E G U R I D A D
                                    // -------------------------------------------
                                    $factor = "IF(
                                                unidadFrecuenciaMedicion = 'Dias', 
                                                1 * 30, 
                                                IF(
                                                    unidadFrecuenciaMedicion = 'Semanas', 
                                                    1 * 4, 
                                                    IF(
                                                        unidadFrecuenciaMedicion = 'Años', 
                                                        1 * 4, 
                                                        valorFrecuenciaMedicion
                                                    )
                                                )
                                            )";
                                    
                                    $preguntaMes = "MOD($mes, 
                                              IF(
                                                unidadFrecuenciaMedicion = 'Dias' OR 
                                                unidadFrecuenciaMedicion = 'Semanas' , $mes, 
                                                    IF(
                                                        unidadFrecuenciaMedicion = 'Meses', 
                                                        valorFrecuenciaMedicion, 
                                                        IF(
                                                            unidadFrecuenciaMedicion = 'Años', 
                                                            $mes, $mes
                                                        )
                                                    )
                                                )
                                            ) = 0";

                                    $total = DB::select(
                                        'Select SUM(Tarea) as Tarea, 
                                                SUM(Ejecutado) as Ejecutado
                                        FROM 
                                        (SELECT
                                            SUM(IF(1
                                                    ,
                                                    (1 * '.$factor.' / valorFrecuenciaMedicion) , 0)) as Tarea, 
                                            0 as Ejecutado
                                        FROM tipoinspeccion TI
                                        left join frecuenciamedicion FM
                                        on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                                        Where TI.Compania_idCompania = '.$idCompania.'
                                        
                                        UNION 

                                        SELECT
                                            0 as Tarea,
                                            SUM(1) as Ejecutado
                                        FROM inspeccion I
                                        Where I.Compania_idCompania = '.$idCompania.'
                                        ) INS ');

                                    $dato = DB::select(
                                        'Select SUM(Tarea) as Tarea, 
                                                SUM(Ejecutado) as Ejecutado
                                        FROM 
                                        (SELECT
                                            SUM(IF('.$preguntaMes.'
                                                    ,
                                                    (1 * '.$factor.' / valorFrecuenciaMedicion) , 0)) as Tarea, 
                                            0 as Ejecutado
                                        FROM tipoinspeccion TI
                                        left join frecuenciamedicion FM
                                        on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                                        Where TI.Compania_idCompania = '.$idCompania.'
                                        
                                        UNION 

                                        SELECT
                                            0 as Tarea,
                                            SUM(IF(MONTH(fechaElaboracionInspeccion) = '.$mes.', 1, 0 )) as Ejecutado
                                        FROM inspeccion I
                                        Where MONTH(fechaElaboracionInspeccion) = '.$mes.' and I.Compania_idCompania = '.$idCompania.'
                                        ) INS ');

                                        
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{number_format($totales["Ejecutado"],0,'.',',').' / '.number_format($totales["Tarea"],0,'.',',')}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{number_format($datos["Ejecutado"],0,'.',',').' / '.number_format($datos["Tarea"],0,'.',',')}}</div>
                                    <div >
                                    ({{number_format($datos["Ejecutado"]/($datos["Tarea"] == 0 ? 1 : $datos["Tarea"])*100,1,'.',',')}}%)</div>                                    
                                    <div>Inspecciones</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:consultarPlanTrabajo(<?php echo $idCompania; ?>,'dashboardConsultarInspecciones','Plan Anual de Inspecciones');">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-md fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                       // -------------------------------------------
        //  E X A M E N E S   M E D I C O S
        // -------------------------------------------
            $total = DB::select(
            'SELECT 
                count(*) as Tarea,
                SUM(IF(fechaExamenMedico != "0000-00-00", 1, 0 )) as Ejecutado

            FROM
            (
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico,
                    IF(unidadFrecuenciaMedicion IN ("Dias" , "Semanas"),
                        1,
                        valorFrecuenciaMedicion
                    ) AS multiploMes
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoexamenmedico CE
                on C.idCargo = CE.Cargo_idCargo
                left join frecuenciamedicion FM
                on CE.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join tipoexamenmedico TEC
                on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = CE.TipoExamenMedico_idTipoExamenMedico
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL  and 
                    T.Compania_idCompania = '.$idCompania .' 
                group by idTercero, idTipoExamenMedico
            ) Examen
            ');

        $dato = DB::select(
            'SELECT 
                SUM(IF( (DATE_FORMAT(fechaIngresoTerceroInformacion, "%Y-%m") = "'.$anomes.'" AND ING = 1) OR 
                (DATE_FORMAT(fechaRetiroTerceroInformacion, "%Y-%m") = "'.$anomes.'" AND RET = 1) OR 
                (MOD('.$mes.',Examen.multiploMes) = 0 ) , 1 , 0) ) as Tarea,
                SUM(IF(DATE_FORMAT(fechaExamenMedico, "%Y-%m") = "'.$anomes.'", 1, 0 )) as Ejecutado

            FROM
            (
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico,
                    IF(unidadFrecuenciaMedicion IN ("Dias" , "Semanas"),
                        1,
                        valorFrecuenciaMedicion
                    ) AS multiploMes
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoexamenmedico CE
                on C.idCargo = CE.Cargo_idCargo
                left join frecuenciamedicion FM
                on CE.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join tipoexamenmedico TEC
                on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = CE.TipoExamenMedico_idTipoExamenMedico
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL  and 
                    T.Compania_idCompania = '.$idCompania .' 
                group by idTercero, idTipoExamenMedico
            ) Examen
            ');

                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{$totales["Ejecutado"].' / '.$totales["Tarea"]}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{$datos["Ejecutado"].' / '.$datos["Tarea"]}}</div>
                                    <div >
                                    ({{number_format($datos["Ejecutado"]/($datos["Tarea"] == 0 ? 1 : $datos["Tarea"])*100,1,'.',',')}}%)</div>                                    
                                    <div>Exámenes Médicos</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:consultarPlanTrabajo(<?php echo $idCompania; ?>,'dashboardConsultarExamenes','Plan Anual de Exámenes Médicos');">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ambulance fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                                                                        
                                    // -------------------------------------------
                                    // A C C I D E N T E S / I N C I D E N T E S
                                    // -------------------------------------------

                                    $total = DB::select(
                                        'SELECT 
                                            SUM(1) as Tarea,
                                            SUM(IF(Acc.idAccidente IS NULL, 0, 1)) as Ejecutado
                                        FROM ausentismo Aus
                                        left join accidente Acc
                                        on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
                                        left join tercero T
                                        on Aus.Tercero_idTercero = T.idTercero
                                        Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
                                            Aus.Compania_idCompania = '.$idCompania .';');

                                    $dato = DB::select(
                                        'SELECT 
                                            SUM(IF(MONTH(fechaElaboracionAusentismo) = '.$mes.', 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaOcurrenciaAccidente) = '.$mes.', IF(Acc.idAccidente IS NULL, 0, 1), 0)) as Ejecutado
                                        FROM ausentismo Aus
                                        left join accidente Acc
                                        on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
                                        left join tercero T
                                        on Aus.Tercero_idTercero = T.idTercero
                                        Where (MONTH(fechaElaboracionAusentismo) = '.$mes.' or
                                            MONTH(fechaOcurrenciaAccidente) = '.$mes.') and 
                                            (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
                                            Aus.Compania_idCompania = '.$idCompania .';');

                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{$totales["Ejecutado"].' / '.$totales["Tarea"]}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{$datos["Ejecutado"].' / '.$datos["Tarea"]}}</div>
                                    <div >
                                    ({{number_format($datos["Ejecutado"]/($datos["Tarea"] == 0 ? 1 : $datos["Tarea"])*100,1,'.',',')}}%)</div>                                    
                                    <div>Accidentes</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:consultarPlanTrabajo(<?php echo $idCompania; ?>,'dashboardConsultarAccidentes','Plan Anual de Accidentes');">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idConformacionGrupoApoyo) as total From conformaciongrupoapoyo Where MONTH(fechaConformacionGrupoApoyo) = ".$mes." and Compania_idCompania = ".$idCompania);

                                        // -------------------------------------------
                                        //  G R U P O S   D E   A P O Y O
                                        // -------------------------------------------
                                        $total = DB::select(
                                            'SELECT SUM(Tarea) as Tarea, SUM(Ejecutado) as Ejecutado
                                            FROM 
                                            (
                                                SELECT 
                                                    SUM(1) as Tarea, 
                                                    0 as Ejecutado 
                                                FROM 
                                                    grupoapoyo GA 
                                                    left join frecuenciamedicion FM on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion 
                                                Where 
                                                     GA.Compania_idCompania = '.$idCompania .'
                                                 
                                            UNION
                                                 
                                                SELECT 
                                                    0 as Tarea, 
                                                    SUM(1) as Ejecutado 
                                                FROM 
                                                    grupoapoyo GA 
                                                    left join frecuenciamedicion FM on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion 
                                                    right join actagrupoapoyo AGA on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo 
                                                Where 
                                                     GA.Compania_idCompania = '.$idCompania .'
                                            ) res');

                                        $dato = DB::select(
                                            'SELECT SUM(Tarea) as Tarea, SUM(Ejecutado) as Ejecutado
                                            FROM 
                                            (
                                                SELECT 
                                                    SUM(IF((MOD('.$mes.', valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")) OR 
                                                            (valorFrecuenciaMedicion = 1 and unidadFrecuenciaMedicion IN ("Meses")), 1, 0)) as Tarea, 
                                                    0 as Ejecutado 
                                                FROM 
                                                    grupoapoyo GA 
                                                    left join frecuenciamedicion FM on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion 
                                                Where 
                                                     GA.Compania_idCompania = '.$idCompania .'
                                                 
                                            UNION
                                                 
                                                SELECT 
                                                    0 as Tarea, 
                                                    SUM(IF(MONTH(fechaActaGrupoApoyo) = '.$mes.', 1, 0)) as Ejecutado 
                                                FROM 
                                                    grupoapoyo GA 
                                                    left join frecuenciamedicion FM on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion 
                                                    left join actagrupoapoyo AGA on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo 
                                                Where MONTH(fechaActaGrupoApoyo) = '.$mes.' and 
                                                     GA.Compania_idCompania = '.$idCompania .'
                                            ) res');
                                        
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{$totales["Ejecutado"].' / '.$totales["Tarea"]}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{$datos["Ejecutado"].' / '.$datos["Tarea"]}}</div>
                                    <div >
                                    ({{number_format($datos["Ejecutado"]/($datos["Tarea"] == 0 ? 1 : $datos["Tarea"])*100,1,'.',',')}}%)</div>                                    
                                    <div>Grupos Apoyo</div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:consultarPlanTrabajo(<?php echo $idCompania; ?>,'dashboardConsultarGrupos','Plan Anual de Grupos de Apoyo');">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>  
                        </a>
                    </div>
                </div>
                
            </div>
            <!-- /.row -->
            <div class="row">


                <?php
                // Consultamos todos los indicadores creados en la compañia actual
                    $cuadroMandoObjeto = DB::table('cuadromando as CM')
                        ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, visualizacionCuadroMando'))
                        ->where("Compania_idCompania", $idCompania) 
            
                        ->get();    

                    $colores = array("cornflowerblue", "lightskyblue", "lightgreen", "yellowgreen", "orange", "darkorange","red", "blue", "yellow","purple","pink","gray","lime","brown", "navy","olive" ,"fuchshia");
                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                    foreach ($cuadroMandoObjeto as $key => $value) 
                    {
                        $CuadroMando = (array) $value;
                        // para cada indicador, consultamos los resultados de calculos en la tabla de indicadores
                        $indicadores = DB::table('indicador as I')
                                ->leftJoin('cuadromando as CM', 'I.CuadroMando_idCuadroMando', '=', 'CM.idCuadroMando')
                                ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
                                ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, fechaCalculoIndicador, fechaCorteIndicador, valorIndicador, nombreFrecuenciaMedicion, tipoMetaCuadroMando'))
                                ->where('CuadroMando_idCuadroMando','=',$CuadroMando['idCuadroMando'])
                                ->get();
                                                
                        $arrayLabels = '[';
                        $arrayDatos = '[';
                        $total = 0;
                        for ($i=0; $i <count($indicadores) ; $i++) 
                        { 
                            $ind = get_object_vars($indicadores[$i]);

                            $total += $ind['valorIndicador'];
                        }
                        
                        foreach ($indicadores as $pos => $valor) 
                        {
                            $Indicador = (array) $valor;
                            
                            $dt = strtotime($Indicador['fechaCorteIndicador']);
                            $month = array("","Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                            
                            $fecha_reg = "'".$month[date('n', $dt)]."/".date("Y", $dt)."'";

                            switch ($CuadroMando['visualizacionCuadroMando']) {
                                case 'Lineas':
                                    $arrayLabels .= $fecha_reg.",";
                                    $arrayDatos .= $Indicador["valorIndicador"]." ,";
                                    break;

                                case 'Barras':
                                    $arrayLabels .= $fecha_reg.",";
                                    $arrayDatos .= $Indicador["valorIndicador"]." ,";
                                    break;

                                case 'Dona':
                                    $valor = ($Indicador["valorIndicador"]/$total)*360;
                                    $arrayDatos .= "{value: ".$valor.", 
                                                    color: '".$colores[array_rand($colores)]."',
                                                    highlight: '".$colores[array_rand($colores)]."',
                                                    label: ".$fecha_reg."},
                                                    ";
                                    break;

                                case 'Area':
                                    $arrayLabels .= $fecha_reg.",";
                                    $arrayDatos .= $Indicador["valorIndicador"]." ,";
                                    break;
                                
                                default:
                                    $arrayLabels .= $fecha_reg.",";
                                    $arrayDatos .= $Indicador["valorIndicador"]." ,";
                                    break;
                            }

                            
                        }
                        $arrayLabels = substr($arrayLabels,0,strlen($arrayLabels)-1);
                        $arrayLabels .= "]";
                        $arrayDatos = substr($arrayDatos,0,strlen($arrayDatos)-1);
                        $arrayDatos .= "]";

                        echo '                                        
                                    <div class="col-lg-6 col-sm-12 col-md-6">
                                      <div class="panel panel-primary" >
                                        <div class="panel-heading">
                                         <i class="fa fa-pie-chart fa-fw"></i> '.$CuadroMando['indicadorCuadroMando'].'<br>
                                        <i class="fa fa-superscript fa-fw"></i> '.$CuadroMando['formulaCuadroMando'].'
                                        </div>
                                        <div class="panel-body" style="min-height: 300px; max-height: 500px;">
                                              <canvas id="'.$CuadroMando['idCuadroMando'].'" ></canvas>
                                        </div>
                                      </div>
                                    </div>';
                        
                        

                        switch ($CuadroMando['visualizacionCuadroMando']) {
                                case 'Lineas':

                                    graficoLinea($CuadroMando['idCuadroMando'], $arrayLabels, $arrayDatos);

                                    break;

                                case 'Barras':
                                    graficoBarra($CuadroMando['idCuadroMando'], $arrayLabels, $arrayDatos);
                                    break;

                                case 'Dona':
                                    graficoDona($CuadroMando['idCuadroMando'], $arrayDatos);
                                    break;

                                case 'Area':
                                    graficoArea($CuadroMando['idCuadroMando'], $arrayLabels, $arrayDatos);
                                    break;
                                
                                default:
                                    graficoBarra($CuadroMando['idCuadroMando'], $arrayLabels, $arrayDatos);
                                    break;
                            }
                    }
                ?>
                
                
             
               
                <!-- /.col-lg-8 -->
                <div class="col-lg-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <i class="fa fa-pie-chart fa-fw"></i> Indicadores de Gestión
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php 

                            $indicadores = DB::table('indicador as I')
                                ->leftJoin('cuadromando as CM', 'I.CuadroMando_idCuadroMando', '=', 'CM.idCuadroMando')
                                ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
                                ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, fechaCalculoIndicador, fechaCorteIndicador, valorIndicador, nombreFrecuenciaMedicion, tipoMetaCuadroMando'))
                                ->where("Compania_idCompania", $idCompania)
                                ->get();
                            // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                            $Indicador = array();
                            foreach ($indicadores as $key => $value) 
                            {
                                $Indicador[] = (array) $value;
                            }

                            // recorremos cada indicador para calcularlo y almacenar su resultado en la tabla de indicadores
                            for ($i=0; $i < count($Indicador); $i++) 
                            { 
                                echo '<div class="list-group">
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["indicadorCuadroMando"].'</div>
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["formulaCuadroMando"].'</div>
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["nombreFrecuenciaMedicion"].'  ('.$Indicador[$i]["fechaCorteIndicador"].')'.'</div>
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["fechaCalculoIndicador"].'</div>
                                        <span class="pull-right text-muted small"><em>'.number_format($Indicador[$i]["valorIndicador"],2,'.',',').' '.($Indicador[$i]["tipoMetaCuadroMando"] == 'C' ? 'Und' : $Indicador[$i]["tipoMetaCuadroMando"]).'</em></span>
                                    </div>';
                            }
                        ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>

                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->




<?php
function graficoLinea($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        var ch = document.getElementById("'.$marco.'").getContext("2d");
                var data = 
                        {
                            labels: '.$arrayLabels.',
                            datasets: 
                            [
                                {
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    highlightFill: "rgba(220,220,220,0.75)",
                                    highlightStroke: "rgba(220,220,220,1)",
                                    data: '.$arrayDatos.'
                                }
                            ]
                        };
                var myLineChart = new Chart(ch).Line(data);

    </script>';
}

function graficoArea($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        var ch = document.getElementById("'.$marco.'").getContext("2d");
                var data = 
                        {
                            labels: '.$arrayLabels.',
                            datasets: 
                            [
                                {
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    highlightFill: "rgba(220,220,220,0.75)",
                                    highlightStroke: "rgba(220,220,220,1)",
                                    data: '.$arrayDatos.'
                                }
                            ]
                        };
                var myLineChart = new Chart(ch).Line(data);

    </script>';
}


function graficoBarra($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        
        var chrt = document.getElementById("'.$marco.'").getContext("2d");
                var data = {
                    labels: '.$arrayLabels.',
                    datasets: [
                        {
                            fillColor: "rgba(220,120,220,0.8)",
                            strokeColor: "rgba(220,120,220,0.8)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            data: '.$arrayDatos.',
                        }
                    ]
                };
                var myFirstChart = new Chart(chrt).Bar(data);

        </script>';
}

function graficoDona($marco, $arrayDatos)
{
    echo '
         <script type="text/javascript">
         var ctx = $("#'.$marco.'").get(0).getContext("2d");

                var data = 
                    '.$arrayDatos.';

                //draw
                var piechart = new Chart(ctx).Doughnut(data);
            
        </script>';
}
?>


@stop