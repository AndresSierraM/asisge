function consultarPlanTrabajo(año, letra, procesos, idDiv)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'año' : año, 
                    'letra': letra,
                    'procesos': procesos,
                    'idDiv' : idDiv},
            url:   'http://'+location.host+'/consultarPlanTrabajo',
            type:  'post',
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                if(idDiv != 'containerPlanTrabajo')
                {
                    $("#"+idDiv ).html(respuesta);
                }
                else
                {
                    $(".containerPlanTrabajo").html(respuesta) ;
                    $(".PlanTrabajo .modal-title div").html('Detalles de Plan de Trabajo');
                    $('.PlanTrabajo').css('display', 'block');
                }
            },
            error: function(xhr,err)
            { 
                alert("Error "+xhr);
            }
        });
}