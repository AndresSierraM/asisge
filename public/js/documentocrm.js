
function abrirModalCampos()
{
    $('#ModalCampos').modal('show');

}


function abrirModalCompania()
{
    $('#ModalCompanias').modal('show');

}

function abrirModalRol()
{
    $('#ModalRoles').modal('show');

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
                $('#descripcionCampoCRM'+reg).val(respuesta[0]['descripcionCampoCRM']);

                // si no es seleccion para grid
                if(respuesta[0]["gridCampoCRM"] == 0)
                {    
                    $("#mostrarGridDocumentoCRMCampo"+(reg )).val(0);
                    $("#mostrarGridDocumentoCRMCampoC"+(reg )).css('display', 'none');
                }
                
                // si no es seleccion para obligatoriedad
                if(respuesta[0]["obligatorioCampoCRM"] == 0)
                {    
                    $("#obligatorioDocumentoCRMCampo"+(reg )).val(0);
                    $("#obligatorioDocumentoCRMCampoC"+(reg )).css('display', 'none');
                }

                
                
            },
            error: function(xhr,err)
            { 
                alert("Error");
            }
        });
}


function llenarDatosCompania(id, reg)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {idCompania: id},
            url:   'http://'+location.host+'/llenarCompania/',
            type:  'post',
            beforeSend: function(){
                },
            success: function(respuesta)
            {
                $('#nombreCompania'+reg).val(respuesta);
                
            },
            error: function(xhr,err)
            { 
                alert("Error");
            }
        });
}

function llenarDatosRol(id, reg)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {idRol: id},
            url:   'http://'+location.host+'/llenarRol/',
            type:  'post',
            beforeSend: function(){
                },
            success: function(respuesta)
            {
                $('#nombreRol'+reg).val(respuesta);
                
            },
            error: function(xhr,err)
            { 
                alert("Error");
            }
        });
}