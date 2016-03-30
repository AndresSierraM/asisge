@extends('layouts.menudinamico')
    
    @section('clases')

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


        <!-- jQuery 2.0.2 -->
        <!-- {!! Html::script('http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'); !!} -->
        <!-- Bootstrap -->
        <!-- {!! Html::script('../../js/bootstrap.min.js'); !!} -->
        <!-- AdminLTE App -->
        <!-- {!! Html::script('../../js/AdminLTE/app.js'); !!} -->
        <!-- AdminLTE for demo purposes -->
        <!-- {!! Html::script('js/AdminLTE/demo.js'); !!} -->
        <!-- FLOT CHARTS -->
        {!! Html::script('sb-admin/bower_components/flot/jquery.flot.js'); !!}
        <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
        {!! Html::script('sb-admin/bower_components/flot/jquery.flot.resize.js'); !!}
        <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
        {!! Html::script('sb-admin/bower_components/flot/jquery.flot.pie.js'); !!}
        <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
        {!! Html::script('sb-admin/bower_components/flot/jquery.flot.categories.js'); !!}



    <!-- Custom Fonts -->
    {!!Html::style('sb-admin/bower_components/font-awesome/css/font-awesome.min.css'); !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    
       
        {!! Html::style('sb-admin/bower_components/metisMenu/dist/metisMenu.min.css'); !!}
        {!! Html::style('sb-admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css'); !!}
        {!! Html::style('sb-admin/bower_components/datatables-responsive/css/dataTables.responsive.css'); !!}
        {!! Html::style('sb-admin/dist/css/sb-admin-2.css'); !!}
        {!! Html::style('sb-admin/bower_components/font-awesome/css/font-awesome.min.css'); !!}


        {!! Html::style('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'); !!}
        {!! Html::script('//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'); !!}
        {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'); !!}
        {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js'); !!}

        {!! Html::style('sb-admin/bower_components/flot/examples/examples.css'); !!}
        {!! Html::script('sb-admin/bower_components/flot/jquery.js'); !!}
        {!! Html::script('sb-admin/bower_components/flot/jquery.flot.js'); !!}

        {!! Html::style('sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css'); !!}
        {!! Html::script('sb-admin/bower_components/bootstrap/dist/js/bootstrap.min.js'); !!}



     @stop