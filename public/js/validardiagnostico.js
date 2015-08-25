
$("#Grabar").click(function(){
    var dato = $("#puntuacionDiagnosticoDetalle0").val();
    var route = "http://localhost:8000/diagnostico";
    var token = $("#token").val();

    $.ajax({
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:{puntuacionDiagnosticoDetalle0 : dato},

        success:function(){
            $("#msj-success").fadeIn();
        },

        error:function(msj){
            $("#msj").html(msj.responseJSON.puntuacionDiagnosticoDetalle0);
            $("#msj-error").fadeIn();
        }        
    });

});




<div id="msj-error" class="alert alert-danger alert-dismissible" role="alert"  style="display:none;">
  <strong id="msj"></strong>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

    @if(isset($diagnostico))
        @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
            {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
        @else
            {!!link_to('#', $title='Modificar', $attributes = ["id"=>"Grabar", "class"=>"btn btn-primary"], $secure = null)!!}
        @endif
    @else
        {!!link_to('#', $title='Adicionar', $attributes = ["id"=>"Grabar", "class"=>"btn btn-primary"], $secure = null)!!}
    @endif
    {!! Form::close() !!}



    {!! Html::script('js/validardiagnostico.js') !!}
