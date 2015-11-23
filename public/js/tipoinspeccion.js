

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
        if(document.getElementById("numeroTipoInspeccionPregunta"+(actual)) && 
            document.getElementById("numeroTipoInspeccionPregunta"+(actual)).value == '')
        {
            document.getElementById("numeroTipoInspeccionPregunta"+(actual)).style = "height: 35px; width: 60px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("numeroTipoInspeccionPregunta"+(actual)).style = "height: 35px; width: 60px; background-color:white;";
        } 

        if(document.getElementById("contenidoTipoInspeccionPregunta"+(actual)) && 
            document.getElementById("contenidoTipoInspeccionPregunta"+(actual)).value == '')
        {
            document.getElementById("contenidoTipoInspeccionPregunta"+(actual)).style = "height: 35px; width: 1035px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("contenidoTipoInspeccionPregunta"+(actual)).style = "height: 35px; width: 1035px; background-color:white;";
        } 
    }

    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique los campos resaltados en rojo, son obligatorios');
    }

    return true;
}

