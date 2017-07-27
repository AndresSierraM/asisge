// Funcion que 
function llenarTerceroParticipante(GrupoApoyo_idGrupoApoyo)
{
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'GrupoApoyo_idGrupoApoyo': GrupoApoyo_idGrupoApoyo},
            url:   'http://'+location.host+'/llenarActaGrupoApoyoTerceroFirma/',
            type:  'post',
            // dataType: 'html',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){ 
            // $("#firma").html(respuesta[0]["nombreCompletoTercero"]);
        
              $("#tablaacta").html(respuesta);               
            },

            error:    function(xhr,err){ 
                alert("Error");
            }
        });
}



function cerrarDivFirma()
{
    document.getElementById("signature-pad").style.display = "none";
}



//en el bonton para firmar en el value va a estar el id culto del tercero 
function asisgnaridTercero(idParticipante)
{
    $("#idParticipante").val(idParticipante);
}

function actualizarFirma()
{
    if (signaturePad.isEmpty()) 
    {
        alert("Por Favor Registre Su Firma.");
    } else 
    {
        //window.open(signaturePad.toDataURL());
        reg = '';
        if(document.getElementById("signature-reg").value != 'undefined')
            reg = document.getElementById("signature-reg").value;
        

        document.getElementById("firma"+reg).src = signaturePad.toDataURL() ;
        document.getElementById("firmabase64"+reg).value = signaturePad.toDataURL();
        mostrarFirma();

        // se toma el id  que se selcciona de acta de capacitacion que aca simplemente es llamad Grupo_idGrupoApoyo
        var idActa = $("#GrupoApoyo_idGrupoApoyo").val();
        var idParticipante = $("#idParticipante").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                // en el data se arma con los valores que se tomaron creando los var...
                data: {'idActa' : idActa, 'idParticipante': idParticipante, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaActaGrupoApoyo/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}
