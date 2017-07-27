// Id que llega por parametro el id de INSPECCION solo que con el campo llamado tipoInspeccion
function llenarRealizadoPor(TipoInspeccion_idTipoInspeccion)
{
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'TipoInspeccion_idTipoInspeccion': TipoInspeccion_idTipoInspeccion},
            url:   'http://'+location.host+'/llenarInspeccionFirma/',
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
function asignaridInspeccion(idInspeccion)
{
    $("#idInspeccion").val(idInspeccion);
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

        // se toma el id  que se selcciona de inspeccion que aca simplemente es llamad TipoInspeccion_idTipoInspeccion
        var idActa = $("#TipoInspeccion_idTipoInspeccion").val();
        var idRealizador = $("#idInspeccion").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                // en el data se arma con los valores que se tomaron creando los var...
                data: {'idActa' : idActa, 'idRealizador': idRealizador, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaInspeccion/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}
