// Funcion para cargar los terceros que estan asociados al numero de acta de capacitacion para que estos firmen 
function llenartercero(numeroActaCapacitacion)
{
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'numeroActaCapacitacion': numeroActaCapacitacion},
            url:   'http://'+location.host+'/llenarTerceroFirma/',
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

function asisgnaridTercero(idAsistente)
{
    $("#idAsistente").val(idAsistente);
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

        // se toma el id oculto del modulo
        var idActa = $("#idActaCapacitacion").val();
        var idAsistente = $("#idAsistente").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                // en el data se arma con los valores que se tomaron creando los var...
                data: {'idActa' : idActa, 'idAsistente': idAsistente, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaActaCapacitacion/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}
