function abrirModalCampos()
{
    $('#ModalCampos').modal('show');
}

function llenarDatosCampo(id, reg)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {idCampoCRM: id},
            url:   'http://'+location.host+'/llenarCampo/',
            type:  'post',
            beforeSend: function(){
                },
            success: function(respuesta)
            {
                $('#nombreCampoCRM'+reg).val(respuesta);
                
            },
            error: function(xhr,err)
            { 
                alert("Error");
            }
        });
}