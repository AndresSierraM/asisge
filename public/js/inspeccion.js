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
        if(document.getElementById("Tercero_idResponsable"+(actual)) && 
            (document.getElementById("Tercero_idResponsable"+(actual)).value == 0 &&
             document.getElementById("accionMejoraInspeccionDetalle"+(actual)).value != ''))
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "vertical-align:top; resize:none; width: 200px; height:60px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "vertical-align:top; resize:none; width: 200px; height:60px; background-color:white;";
        } 
    }

    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique los campos resaltados en rojo, deben ser diligenciados');
    }

    return true;
}



function visualizarArchivoInspeccion(rutaImagen)
{
    if (rutaImagen != "") 
    {
        window.open('http://'+location.host+'/imagenes/'+rutaImagen, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=1000,height=1000");
    }
    else
    {
        alert("No hay imagen cargada.");
    }
}