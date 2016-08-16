@extends('layouts.vista')
@section('titulo')<h1 id="titulo"><center>Dashboard</center></h1>@stop

@section('content')
{!!Html::style('angular/bootstrap.css'); !!} 
{!! Html::script('angular/angular.min.js'); !!}
{!! Html::script('angular/Chart.min.js'); !!}
{!! Html::script('angular/angular-chart.min.js'); !!}
{!! Html::script('angular/angular-chart.js'); !!}
{!! Html::script('js/dashboard.js'); !!}

<?php 
    $idCompania = \Session::get("idCompania");
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
                                            SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = '.date("m").', 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = '.date("m").', IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as Ejecutado
                                        From programa P
                                        left join programadetalle PD
                                        on P.idPrograma = PD.Programa_idPrograma
                                        Where   (MONTH(fechaPlaneadaProgramaDetalle) = '.date("m").' or MONTH(fechaEjecucionProgramaDetalle) = '.date("m").') and 
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
                                    $dato = DB::select("Select count(idActaCapacitacion) as total From actacapacitacion Where MONTH(fechaElaboracionActaCapacitacion) = ".date("m")." and Compania_idCompania = ".$idCompania);

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
                                        left join actacapacitacion AC
                                        on PC.idPlanCapacitacion = AC.PlanCapacitacion_idPlanCapacitacion
                                        left join 
                                        (
                                            SELECT * 
                                            FROM  actacapacitaciontema ACT
                                            left join actacapacitacion AC
                                            on ACT.ActaCapacitacion_idActaCapacitacion = AC.idActaCapacitacion
                                            where AC.Compania_idCompania = '.$idCompania .' and ACT.cumpleObjetivoActaCapacitacionTema
                                        )  ACT
                                        on AC.idActaCapacitacion = ACT.ActaCapacitacion_idActaCapacitacion and 
                                        PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
                                        WHere  PC.Compania_idCompania = '.$idCompania );

                                    $dato = DB::select(
                                        'SELECT 
                                            SUM(IF(MONTH(fechaPlanCapacitacionTema) = '.date("m").', 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaPlanCapacitacionTema) = '.date("m").', IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as Ejecutado
                                        From plancapacitacion PC
                                        left join plancapacitaciontema PCT
                                        on PC.idPlanCapacitacion = PCT.PlanCapacitacion_idPlanCapacitacion
                                        left join actacapacitacion AC
                                        on PC.idPlanCapacitacion = AC.PlanCapacitacion_idPlanCapacitacion
                                        left join 
                                        (
                                            SELECT * 
                                            FROM  actacapacitaciontema ACT
                                            left join actacapacitacion AC
                                            on ACT.ActaCapacitacion_idActaCapacitacion = AC.idActaCapacitacion
                                            where AC.Compania_idCompania = '.$idCompania .' and ACT.cumpleObjetivoActaCapacitacionTema
                                        )  ACT
                                        on AC.idActaCapacitacion = ACT.ActaCapacitacion_idActaCapacitacion and 
                                        PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
                                        WHere  MONTH(fechaPlanCapacitacionTema) = '.date("m").' and 
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
                                    $total = DB::select(
                                        'SELECT
                                            SUM(IF(unidadFrecuenciaMedicion IN ("Meses"), 1 , 0)) as Tarea,
                                            SUM(1) as Ejecutado
                                        FROM tipoinspeccion TI
                                        left join frecuenciamedicion FM
                                        on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                                        left join inspeccion I
                                        on TI.idTipoInspeccion = I.TipoInspeccion_idTipoInspeccion
                                        Where TI.Compania_idCompania = '.$idCompania);

                                    $dato = DB::select(
                                        'SELECT
                                            SUM(IF((MOD('.date("m").',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaElaboracionInspeccion) = '.date("m").', 1, 0 )) as Ejecutado
                                        FROM tipoinspeccion TI
                                        left join frecuenciamedicion FM
                                        on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                                        left join inspeccion I
                                        on TI.idTipoInspeccion = I.TipoInspeccion_idTipoInspeccion
                                        Where MONTH(fechaElaboracionInspeccion) = '.date("m").' and 
                                                TI.Compania_idCompania = '.$idCompania);

                                        
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value){$totales = (array) $value;}
                                    foreach ($dato as $key => $value){$datos = (array) $value;}
                                ?>
                                    
                                    <div title="Acumulado total: Ejecutado / Total Tareas">{{$totales["Ejecutado"].' / '.$totales["Tarea"]}}<span >
                                    ({{number_format($totales["Ejecutado"]/($totales["Tarea"] == 0 ? 1 : $totales["Tarea"])*100,1,'.',',')}}%)</span></div>

                                    <div class="huge" title="Acumulado Mes: Ejecutado / Total Tareas">{{$datos["Ejecutado"].' / '.$datos["Tarea"]}}</div>
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
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = '.date("m").' AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = '.date("m").' AND RET = 1) OR (MOD('.date("m").',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0) OR (unidadFrecuenciaMedicion IN ("Años"))) as Tarea,
                SUM(IF(MONTH(fechaExamenMedico) = '.date("m").', 1, 0 )) as Ejecutado
            FROM
            (
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TET.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico 
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join terceroexamenmedico TEM
                on T.idTercero = TEM.Tercero_idTercero
                left join frecuenciamedicion FM
                on TEM.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join tipoexamenmedico TET
                on TEM.TipoExamenMedico_idTipoExamenMedico = TET.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = TEM.TipoExamenMedico_idTipoExamenMedico
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL and 
                    T.Compania_idCompania = '.$idCompania .' 
                group by idTercero, idTipoExamenMedico
             
            UNION

                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico
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
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = '.date("m").' AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = '.date("m").' AND RET = 1) OR (MOD('.date("m").',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0) OR (unidadFrecuenciaMedicion IN ("Años"))) as Tarea,
                SUM(IF(MONTH(fechaExamenMedico) = '.date("m").', 1, 0 )) as Ejecutado
            FROM
            (
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TET.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico 
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join terceroexamenmedico TEM
                on T.idTercero = TEM.Tercero_idTercero
                left join frecuenciamedicion FM
                on TEM.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join tipoexamenmedico TET
                on TEM.TipoExamenMedico_idTipoExamenMedico = TET.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = TEM.TipoExamenMedico_idTipoExamenMedico
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL and 
                    T.Compania_idCompania = '.$idCompania .' 
                group by idTercero, idTipoExamenMedico
             
            UNION

                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico
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
                                            SUM(IF(MONTH(fechaElaboracionAusentismo) = '.date("m").', 1 , 0)) as Tarea,
                                            SUM(IF(MONTH(fechaOcurrenciaAccidente) = '.date("m").', IF(Acc.idAccidente IS NULL, 0, 1), 0)) as Ejecutado
                                        FROM ausentismo Aus
                                        left join accidente Acc
                                        on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
                                        left join tercero T
                                        on Aus.Tercero_idTercero = T.idTercero
                                        Where (MONTH(fechaElaboracionAusentismo) = '.date("m").' or
                                            MONTH(fechaOcurrenciaAccidente) = '.date("m").') and 
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
                                        $dato = DB::select("Select count(idConformacionGrupoApoyo) as total From conformaciongrupoapoyo Where MONTH(fechaConformacionGrupoApoyo) = ".date("m")." and Compania_idCompania = ".$idCompania);

                                        // -------------------------------------------
                                        //  G R U P O S   D E   A P O Y O
                                        // -------------------------------------------
                                        $total = DB::select(
                                            'SELECT 
                                                SUM(IF((MOD('.date("m").',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as Tarea,
                                                SUM(IF(MONTH(fechaActaGrupoApoyo) = '.date("m").', 1, 0 )) as Ejecutado
                                            FROM grupoapoyo GA
                                            left join frecuenciamedicion FM
                                            on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                                            left join actagrupoapoyo AGA
                                            on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo
                                            Where GA.Compania_idCompania = '.$idCompania .' ');

                                        $dato = DB::select(
                                            'SELECT 
                                                SUM(IF((MOD('.date("m").',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as Tarea,
                                                SUM(IF(MONTH(fechaActaGrupoApoyo) = '.date("m").', 1, 0 )) as Ejecutado
                                            FROM grupoapoyo GA
                                            left join frecuenciamedicion FM
                                            on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                                            left join actagrupoapoyo AGA
                                            on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo
                                            Where MONTH(fechaActaGrupoApoyo) = '.date("m").' and 
                                                    GA.Compania_idCompania = '.$idCompania .' ');
                                        
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
                                                
                        $arrayGrafico = '[';
                        foreach ($indicadores as $pos => $valor) 
                        {
                            $Indicador = (array) $valor;
                            $dt = strtotime($Indicador['fechaCorteIndicador']);
                            $month = array("","Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                            
                            $fecha_reg = $month[date('n', $dt)]."/".date("Y", $dt);

                            switch ($CuadroMando['visualizacionCuadroMando']) {
                                case 'Lineas':
                                    $arrayGrafico .= "[".date('n', $dt).", ".$Indicador["valorIndicador"]." ],";
                                    break;

                                case 'Barras':
                                    $arrayGrafico .= "['".$fecha_reg."', ".$Indicador["valorIndicador"]." ],";
                                    break;

                                case 'Dona':
                                    $arrayGrafico .= "{label: '".$fecha_reg."', data: ".$Indicador["valorIndicador"]." },";
                                    break;

                                case 'Area':
                                    $arrayGrafico .= "[".date('n', $dt).", ".$Indicador["valorIndicador"]." ],";
                                    break;
                                
                                default:
                                    $arrayGrafico .= "['".$fecha_reg."', ".$Indicador["valorIndicador"]." ],";
                                    break;
                            }
                             
                            
                        }
                        $arrayGrafico = substr($arrayGrafico,0,strlen($arrayGrafico)-1);
                        $arrayGrafico .= "]";
                        
                        
                        echo '
                        <div class="col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pie-chart fa-fw"></i> '.$CuadroMando['indicadorCuadroMando'].'<br>
                                    <i class="fa fa-superscript fa-fw"></i> '.$CuadroMando['formulaCuadroMando'].'
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div id="indicador'.$CuadroMando['idCuadroMando'].'" style="height: 300px;"></div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                        </div>';

                        switch ($CuadroMando['visualizacionCuadroMando']) {
                                case 'Lineas':

                                    graficoLinea("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;

                                case 'Barras':
                                    graficoBarra("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;

                                case 'Dona':
                                    graficoDona("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;

                                case 'Area':
                                    graficoArea("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;
                                
                                default:
                                    graficoBarra("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
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
function graficoLinea($marco, $arrayGrafico)
{
    echo '
    <script type="text/javascript">
            
            var line_data1 = {
                data: '.$arrayGrafico.'
            };
            
            $.plot("#'.$marco.'", [line_data1], {
                grid: {
                    hoverable: true,
                    borderColor: "#f3f3f3",
                    borderWidth: 1,
                    tickColor: "#f3f3f3"
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false
                },
                yaxis: {
                    show: true,
                },
                xaxis: {
                    show: true
                }
            });
            //Initialize tooltip on hover
            $("<div class=\'tooltip-inner\' id=\''.$marco.'-tooltip\'></div>").css(
            {
                position: "absolute",
                display: "none",
                opacity: 0.8
            }).appendTo("body");
            
            $("#'.$marco.'").bind("plothover", function(event, pos, item) {
                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);
                    $("#'.$marco.'-tooltip").html("Periodo " + x + " / Valor " + y)
                            .css({top: item.pageY + 5, left: item.pageX + 5})
                            .fadeIn(200);
                } else {
                    $("#'.$marco.'-tooltip").hide();
                }
            });

        </script>';
}

function graficoArea($marco, $arrayGrafico)
{
    echo '
    <script type="text/javascript">
                var areaData = '.$arrayGrafico.';
                $.plot("#'.$marco.'", [areaData], {
                    grid: {
                        borderWidth: 0
                    },
                    series: {
                        shadowSize: 0, // Drawing is faster without shadows
                        color: "#00c0ef"
                    },
                    lines: {
                        fill: true //Converts the line chart to area chart                        
                    },
                    yaxis: {
                        show: false
                    },
                    xaxis: {
                        show: false
                    }
                });

        </script>';
}


function graficoBarra($marco, $arrayGrafico)
{
    echo '
    <script type="text/javascript">

                var bar_data = {
                    data: '.$arrayGrafico.',
                    color: "#3c8dbc"
                };
                $.plot("#'.$marco.'", [bar_data], {
                    grid: {
                        borderWidth: 1,
                        borderColor: "#f3f3f3",
                        tickColor: "#f3f3f3"
                    },
                    series: {
                        bars: {
                            show: true,
                            barWidth: 0.5,
                            align: "center"
                        }
                    },
                    xaxis: {
                        mode: "categories",
                        tickLength: 0
                    }
                });

        </script>';
}

function graficoDona($marco, $arrayGrafico)
{
    echo '
         <script type="text/javascript">
                var donutData = '.$arrayGrafico.';
                $.plot("#'.$marco.'", donutData, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            innerRadius: 0.5,
                            label: {
                                show: true,
                                radius: 2 / 3,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: true
                    }
                });
        
            function labelFormatter(label, series) {
                    return "<div style=\'font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;\'>"
                    + label
                    + "<br/>"
                    + Math.round(series.percent) + "%</div>";
            }
        </script>';
}
?>


@stop