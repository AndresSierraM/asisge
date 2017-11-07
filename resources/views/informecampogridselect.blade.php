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
  
    var bd = '<?php echo isset($_GET["basedatos"]) ? $_GET["basedatos"] : ""; ?>';
    var tabla = '<?php echo isset($_GET["tabla"]) ? $_GET["tabla"] : ""; ?>';

    $(document).ready( function () {
        var lastIdx = null;
        configurarGridSelect('tinformecampo',"{!! URL::to ('datosInformeCampo?basedatos="+bd+"&tabla="+tabla+"')!!}");
    });
  </script>

  <div class="container">
    <div class="row">
      <div class="container">
        
        <table id="tinformecampo" name="tinformecampo" class="display table-bordered" width="100%">
          <thead>
            <tr class="btn-default active">
              <th><b>Descripción</b></th>
              <th><b>Campo</b></th>
              <th><b>Tipo</b></th>
              <th><b>Longitud</b></th>
              <th><b>Decimales</b></th>
            </tr>
          </thead>
          <tfoot>
            <tr class="btn-default active">
              
              <th><b>Descripción</b></th>
              <th><b>Campo</b></th>
              <th><b>Tipo</b></th>
              <th><b>Longitud</b></th>
              <th><b>Decimales</b></th>
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
