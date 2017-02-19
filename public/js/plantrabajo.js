function consultarPlanTrabajo(año, letra)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'año' : año, 'letra': letra},
            url:   'http://'+location.host+'/consultarPlanTrabajo',
            type:  'post',
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                $("#plantrabajo" ).html(respuesta);
            },
            error: function(xhr,err)
            { 
                alert("Error "+xhr);
            }
        });
}