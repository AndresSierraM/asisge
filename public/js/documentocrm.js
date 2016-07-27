
function abrirModalCampos()
{
    $('#ModalCampos').modal('show');

}

function llenarDatosCampo(Objeto)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCampo': Objeto.value},
            url:   ip+'/consultarCampo/',
            type:  'post',
            beforeSend: function(){
                },
            success: function(respuesta)
            {
                reg = Objeto.id.replace('idCampoCRM','');

                $('#descripcionCampoCRM'+reg).val(respuesta['descripcionCampoCRM']);
                
            },
            error: function(xhr,err)
            { 
                alert("Error");
            }
        });
}
