{!!Html::script('js/gridselect.js'); !!}


@extends('layouts.modal') 
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

  <script type="text/javascript">
    var tipo = '<?php echo (isset($_GET["tipo"]) ? $_GET["tipo"] : "P"); ?>';
    $(document).ready( function () {
        var lastIdx = null;
        configurarGridSelect('tfichatecnica',"{!! URL::to ('/datosFichaTecnicaSelect?tipo="+tipo+"')!!}");
    });
  </script>
        <div class="container">
            <div class="row">
                <div class="container">
                    <br>
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="1"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Referencia</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Nombre</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Línea</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Sublinea</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Tercero</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Estado</label></a></li>
                        </ul>
                    </div>
                    <table id="tfichatecnica" name="tfichatecnica" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                
                                <th><b>ID</b></th>
                                <th><b>Referencia</b></th>
                                <th><b>Nombre</b></th>
                                <th><b>Línea</b></th>
                                <th><b>Sublinea</b></th>
                                <th><b>Tercero</b></th>
                                <th><b>Estado</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                               
                                <th>ID</th>
                                <th>Referencia</th>
                                <th>Nombre</th>
                                <th>Línea</th>
                                <th>Sublinea</th>
                                <th>Tercero</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>        
                    </table>

                    <div class="modal-footer">
                        <button id="botonOK" name="botonOK" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>
                    
                </div>
            </div>
        </div>


@stop