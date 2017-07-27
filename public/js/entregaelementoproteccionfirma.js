// Id que llega por parametro el id de INSPECCION solo que con el campo llamado tipoInspeccion
function llenarTercero(Tercero_idTercero)
{
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'Tercero_idTercero': Tercero_idTercero},
            url:   'http://'+location.host+'/llenarEntregaElementoProteccionFirma/',
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
function asignaridEntrega(idEntregaElementoProteccion)
{
    $("#idEntregaElementoProteccion").val(idEntregaElementoProteccion);
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

        // se toma el id  que se selcciona en el select de enetregaelementorpoteccionfirma llamad Tercero_idTercero
        var idActa = $("#Tercero_idTercero").val();
        var idEmpleado = $("#idEntregaElementoProteccion").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                // en el data se arma con los valores que se tomaron creando los var...
                data: {'idActa' : idActa, 'idEmpleado': idEmpleado, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaEntregaElementoProteccion/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}
