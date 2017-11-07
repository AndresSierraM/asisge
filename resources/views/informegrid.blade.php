{!!Html::script('js/grid.js'); !!}

@extends('layouts.grid')
@section('titulo')<h3 class="pestana" id="titulo"><center>Diseñador de Informes</center></h3>@stop
@section('content')
<style>
    tfoot input {
                width: 100%;
                padding: 3px;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
</style> 

<?php 
    $visible = '';

    if (isset($datos[0])) 
    {
        $dato = get_object_vars($datos[0]);
        if ($dato['adicionarRolOpcion'] == 1) 
        {
            $visible = 'inline-block;';    
        }
        else
        {
            $visible = 'none;';
        }
    }
    else
    {
        $visible = 'none;';
    }
?>

<script type="text/javascript">
    $(document).ready( function () {
        
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var consultar = '<?php echo (isset($datos[0]) ? $dato["consultarRolOpcion"] : 0);?>';
        
        configurarGrid('tinforme',"{!! URL::to ('/datosInforme?modificar="+modificar+"&eliminar="+eliminar+"&consultar="+consultar+"')!!}");
    });
</script>


<div class="container">
    <div class="row">
        <div class="container">
            <br>
            <div class="btn-group" style="margin-left: 94%;margin-bottom:0px" title="Columns">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                    <i class="glyphicon glyphicon-th icon-th"></i> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a class="toggle-vis" data-column="0"><label> Iconos</label></a></li>
                    <li><a class="toggle-vis" data-column="1"><label> ID</label></a></li>
                    <li><a class="toggle-vis" data-column="2"><label> Nombre</label></a></li>
                    <li><a class="toggle-vis" data-column="3"><label> Descripción</label></a></li>
                    <li><a class="toggle-vis" data-column="4"><label> Categoría</label></a></li>
                </ul>
            </div>
            <table id="tinforme" name="tpaquete" class="display table-bordered" width="100%">
                <thead>
                    <tr class="btn-primary active">
                        <th style="width:60px;padding: 1px 8px;" data-orderable="false">
                        <a href="informe/create"><span style= "display: <?php echo $visible;?> color:white;" class="glyphicon glyphicon-plus"></span></a>
                            <a href="#"><span style="color:white" class="glyphicon glyphicon-refresh"></span></a>
                            <a><span class="glyphicon glyphicon-remove-sign" style="color:white; cursor:pointer;" id="btnLimpiarFiltros"></span></a>
                        </th>
                        <th><b>ID</b></th>
                        <th><b>Nombre</b></th>
                        <th><b>Descripción</b></th>
                        <th><b>Categoría</b></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="btn-default active">
                        <th style="width:40px;padding: 1px 8px;">
                            &nbsp;
                        </th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@stop