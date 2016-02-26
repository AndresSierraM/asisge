
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SiSoft - Sistema Integrado de Salud Ocupacional</title>

    <!-- Bootstrap Core CSS -->
    {!!Html::style('sb-admin/bower_components/metisMenu/dist/metisMenu.min.css'); !!}
    {!!Html::style('sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css'); !!}

    <!-- MetisMenu CSS -->
    {!!Html::style('sb-admin/bower_components/metisMenu/dist/metisMenu.min.css'); !!}

    <!-- Timeline CSS -->
    {!!Html::style('sb-admin/dist/css/timeline.css'); !!}

    <!-- Custom CSS -->
    {!!Html::style('sb-admin/dist/css/sb-admin-2.css'); !!}

    <!-- Morris Charts CSS -->
    <!-- {!!Html::style('sb-admin/bower_components/morrisjs/morris.css'); !!} -->
    
    {!! Html::style('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'); !!}
    {!! Html::script('//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'); !!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'); !!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js'); !!}


    <!-- Custom Fonts -->
    {!!Html::style('sb-admin/bower_components/font-awesome/css/font-awesome.min.css'); !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SiSoft V 1.0.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Completo (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Ver Todas</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Cuadro de Mando</a>
                        </li>
                        <li>
                            <a href="plantrabajo"><i class="fa fa-calendar fa-fw"></i> Plan de Trabajo</a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-thumbs-o-up fa-fw"></i> A.C.P.M</a>
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 
                                    $dato = DB::select("Select count(idPrograma) as total From programa Where MONTH(fechaElaboracionPrograma) = ".date("m"));
                                    
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($dato as $key => $value) 
                                    {
                                        $datos = (array) $value;
                                    }
                                ?>
                                    <div class="huge">{{$datos["total"]}}</div>
                                    <div>Programas</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 
                                    $dato = DB::select("Select count(idActaCapacitacion) as total From actacapacitacion Where MONTH(fechaElaboracionActaCapacitacion) = ".date("m"));
                                    
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($dato as $key => $value) 
                                    {
                                        $datos = (array) $value;
                                    }
                                ?>
                                    <div class="huge">{{$datos["total"]}}</div>
                                    <div>Capacitaciones</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idInspeccion) as total From inspeccion Where MONTH(fechaElaboracionInspeccion) = ".date("m"));
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Inspecciones</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-md fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idExamenMedico) as total From examenmedico Where MONTH(fechaExamenMedico) = ".date("m"));
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Exámenes Médicos</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-secret fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idAusentismo) as total From Ausentismo Where MONTH(fechaElaboracionAusentismo) = ".date("m"));
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Ausencias</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ambulance fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select(
                                           "Select count(idAusentismo) as total, 
                                                    SUM(IF(idAccidente IS NULL, 0, 1)) as total2 
                                            From ausentismo 
                                            left join Accidente 
                                            on idAusentismo = Ausentismo_idAusentismo 
                                            Where (tipoAusentismo like '%Accidente%' or tipoAusentismo like '%Incidente%') and MONTH(fechaElaboracionAusentismo) = ".date("m"));
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}} / {{$datos["total2"]}}</div>                                    
                                    <div>Accidentes</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idConformacionGrupoApoyo) as total From conformaciongrupoapoyo Where MONTH(fechaConformacionGrupoApoyo) = ".date("m"));
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Grupos Apoyo</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-headphones fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idEntregaElementoProteccion) as total From entregaelementoproteccion Where MONTH(fechaEntregaElementoProteccion) = ".date("m"));
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Entregas EPP</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
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
                    $cuadroMandoObjeto = DB::table('cuadromando as CM')
                        ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, visualizacionCuadroMando'))
                        ->where('idCuadroMando','=',1)
                        ->get();

                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                    foreach ($cuadroMandoObjeto as $key => $value) 
                    {
                        $CuadroMando = (array) $value;

                        $indicadores = DB::table('indicador as I')
                                ->leftJoin('cuadromando as CM', 'I.CuadroMando_idCuadroMando', '=', 'CM.idCuadroMando')
                                ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
                                ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, fechaCalculoIndicador, fechaCorteIndicador, valorIndicador, nombreFrecuenciaMedicion, tipoMetaCuadroMando'))
                                ->where('CuadroMando_idCuadroMando','=',$CuadroMando['idCuadroMando'])
                                ->get();
                                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                        $arrayGrafico = '';
                        foreach ($indicadores as $pos => $valor) 
                        {
                            $Indicador = (array) $valor;
                            $dt = strtotime($Indicador['fechaCorteIndicador']);
                            $month = array("","Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                            
                            $fecha_reg = $month[date('n', $dt)]."/".date("Y", $dt);

                            $arrayGrafico .= "{ aspecto: '".$fecha_reg."', value: ".$Indicador["valorIndicador"]." },";
                        }

                        echo '
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-pie-chart fa-fw"></i> '.$CuadroMando['indicadorCuadroMando'].'<br>
                                    <i class="fa fa-superscript fa-fw"></i> '.$CuadroMando['formulaCuadroMando'].'
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div id="indicador'.$CuadroMando['idCuadroMando'].'" style="height: 100%; width: 100%;"></div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                        </div>';


                        echo '
                        <script type="text/javascript">
                            
                            new Morris.Bar({
                            // ID of the element in which to draw the chart.
                            element: "indicador'.$CuadroMando['idCuadroMando'].'",
                            // Chart data records -- each entry in this array corresponds to a point on
                            // the chart.
                            data: [
                            '.$arrayGrafico.'
                            ],
                            // The name of the data record attribute that contains x-values.
                            xkey: "aspecto",
                            // A list of names of data record attributes that contain y-values.
                            ykeys: ["value"],
                            // Labels for the ykeys -- will be displayed when you hover over the
                            // chart.
                            labels: ["%Cump"],
                            resize: true,
                            hideHover: "auto",
                            ymax: 10
                            });

                        </script>';

                    }
                ?>
                
                
             
               
                <!-- /.col-lg-8 -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
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
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->





</body>

</html>
