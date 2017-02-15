function consultarExamenPlanTrabajo(letra)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'letra' : letra},
            url:   'http://'+location.host+'/consultarExamenMedicoPlanTrabajo',
            type:  'post',
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                $("#examenmedico1" ).html(respuesta);
            },
            error: function(xhr,err)
            { 
                alert("Error "+xhr);
            }
        });
}