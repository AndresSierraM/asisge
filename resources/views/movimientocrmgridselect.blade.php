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

    var idDoc = '<?php echo (isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : ""); ?>';
    $(document).ready( function () {
       
        configurarGridSelect('tmovimientocrm',"{!! URL::to ('datosMovimientoCRMSelect?idDocumentoCRM="+idDoc+"')!!}");
        
    });

</script>


        <div class="container">
            <div class="row">
                <div class="container">
                    <table id="tmovimientocrm" name="tmovimientocrm" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-primary active">
                                <th><b>ID</b></th>
                                <th><b>Número</b></th>
                                <th><b>Asunto</b></th>
                                <th><b>Fecha Solicitud</b></th>
                                <th><b>Fecha Real Solución</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th>ID</th>
                                <th>Número</th>
                                <th>Asunto</th>
                                <th>Fecha Solicitud</th>
                                <th>Fecha Real Solución</th>
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
