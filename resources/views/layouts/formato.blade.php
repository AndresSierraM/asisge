<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {!! Html::style('sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css'); !!}
        {!! Html::style('sb-admin/bower_components/metisMenu/dist/metisMenu.min.css'); !!}
        {!! Html::style('sb-admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css'); !!}
        {!! Html::style('sb-admin/bower_components/datatables-responsive/css/dataTables.responsive.css'); !!}
        {!! Html::style('sb-admin/dist/css/sb-admin-2.css'); !!}
        {!! Html::style('sb-admin/bower_components/font-awesome/css/font-awesome.min.css'); !!}
    </head>
    <body>
        
                @yield('contenido')
            </div>
        </div>
    </body>
</html>