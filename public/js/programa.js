function habilitarSubmit(event)
{
    event.preventDefault();
    

    validarformulario();
}

function validarformulario()
{
    var resp = true;
    // Validamos los datos de detalle
    for(actual = 0; actual < document.getElementById('registros').value ; actual++)
    {
        if(document.getElementById("actividadProgramaDetalle"+(actual)) && 
                (document.getElementById("actividadProgramaDetalle"+(actual)).value == ''))
        {
            document.getElementById("actividadProgramaDetalle"+(actual)).style = "width: 400px; height: 35px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("actividadProgramaDetalle"+(actual)).style = "width: 400px; height: 35px; background-color:white;";
        }
         
        /*if(document.getElementById("Tercero_idResponsable"+(actual)) && 
                (document.getElementById("Tercero_idResponsable"+(actual)).value == 0))  
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:red;";
            resp = false;
        }
        else
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:white;";
        }

        if(document.getElementById("Documento_idDocumento"+(actual)) && 
                (document.getElementById("Documento_idDocumento"+(actual)).value == 0))
        {
            document.getElementById("Documento_idDocumento"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:red;";
            resp = false;
        }
        else
        {
            document.getElementById("Documento_idDocumento"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:white;";
        }*/
    }

    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique, los campos resaltados en rojo son obligatorios');
    }

    return true;
}