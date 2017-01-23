function cargarEntrevista (idEncuesta)
{
    
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idEncuesta': idEncuesta},
            url:   'http://'+location.host+'/CargarEntrevista/',
            type:  'POST',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                $("#encuestas").html(respuesta.contenido);
                
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}




function calificarformacion(idRequerido)
{

  // recibimos como parametro el id del campo de educacion requerida, con este tomamos el numero 
    // del registro para referirnos a los demas campos

    // si al id que recibimos, le quitamos el nombre, nos queda el numero del registro 
    var reg = idRequerido.replace('PerfilCargo_idAspirante_Formacion', '') ;

    // con el numero de registro comparamos los valores de los  campos (solo de ese registro)
    if ($("#PerfilCargo_idRequerido_Formacion"+reg).val() == $("#PerfilCargo_idAspirante_Formacion"+reg).val())

    {
          $('#calificacionEntrevistaFormacion'+reg+' option[value=\'Total\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEntrevistaFormacion'+reg+' option[value=\'No Cumple\']').prop('selected','selected');
    }
}


function calificareducacion(idRequerido)
{
    // recibimos como parametro el id del campo de educacion requerida, con este tomamos el numero 
    // del registro para referirnos a los demas campos

    // si al id que recibimos, le quitamos el nombre, nos queda el numero del registro 
    var reg = idRequerido.replace('PerfilCargo_idAspirante_Educacion', '') ;

    // con el numero de registro comparamos los valores de los 2 campos (solo de ese registro)
    if ($("#PerfilCargo_idRequerido_Educacion"+reg).val() == $("#PerfilCargo_idAspirante_Educacion"+reg).val())

    {
          $('#calificacionEntrevistaEducacion'+reg+' option[value=\'Total\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEntrevistaEducacion'+reg+' option[value=\'No Cumple\']').prop('selected','selected');
    }

}



function compararAniosExperiencia()
{
    if(parseFloat($("#experienciaAspiranteEntrevista").val())  >= parseFloat($("#experienciaRequeridaEntrevista").val()))
        $("#experienciaRequeridaEntrevista").css("font-weight","bold").css("background-color", "#98FB98");
    else
        $("#experienciaRequeridaEntrevista").css("font-weight","bold").css("background-color", "#990000");
}

function llenarEntrevistaCompetencia(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarEntrevistaCompetencia/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                // Limpiar el div de la multiregistro
                document.getElementById("EntrevistaCompetencia_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();

                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idCompetenciaPregunta"];
                    nombres[i] = respuesta[i]["preguntaCompetenciaPregunta"];
                    
                    var valores = new Array(0,valor[i],nombres[i],'',1);
                    window.parent.EntrevistaCompentencia.agregarCampos(valores,'A'); 

                }  
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}

function llenarFormacionCargo(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarFormacionCargo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                // Limpiar el div de la multiregistro
                document.getElementById("FormacionEntrevista_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();
                var porcentaje = new Array();

                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"];
                    porcentaje[i] = respuesta[i]["porcentajeCargoFormacion"];
                    
                    var valores = new Array(0,nombres[i],valor[i],porcentaje[i],0,0,0);
                    window.parent.Formacionentrevista.agregarCampos(valores,'A'); 

                }  
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}



function llenarEducacionCargo(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarEducacionCargo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){
              
                // Limpiar el div de la multiregistro
                document.getElementById("EducacionEntrevista_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();
                var porcentaje = new Array();

                $("#experienciaRequeridaEntrevista").val(respuesta[0]["aniosExperienciaCargo"]);
                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"]; 
                    porcentaje[i] = respuesta[i]["porcentajeCargoEducacion"]; 

                    var valores = new Array(0,nombres[i],valor[i],porcentaje[i],0,0,0);  
                    window.parent.Educacionentrevista.agregarCampos(valores,'A'); 
                }  
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}


 function mostrarDivGenerales(id)
 {
 
 
  if (id == 'General') 
  {
    $("#General").css('display', 'block');
    $("#Competencias").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#otraspreguntas").css('display', 'none');
  }


  else if (id == 'Competencias')
  {

    $("#General").css('display', 'none');  
    $("#Competencias").css('display', 'block');
    $("#Habilidades").css('display', 'none');
    $("#otraspreguntas").css('display', 'none');
  }

  else if (id == 'Habilidades')
  {

    $("#General").css('display', 'none');
    $("#Competencias").css('display', 'none');
    $("#Habilidades").css('display', 'block');
    $("#otraspreguntas").css('display', 'none');
  }

  else if (id == 'otraspreguntas')
  {
    
    $("#General").css('display', 'none');
    $("#Competencias").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#otraspreguntas").css('display', 'block');
  }


 }



 function mostrarDivInternos(id)
 {
 

    if (id == 'aspectopersonal') 
    {
        
      $("#aspectopersonal").css('display','block');
      $("#laboral").css('display','none');
      $("#sociales").css('display','none');
      $("#educativo").css('display','none');
     
    }

    else if (id == 'educativo') 
    {
      $("#aspectopersonal").css('display','none');
      $("#laboral").css('display','none');
      $("#sociales").css('display','none');
      $("#educativo").css('display','block');

    }
    else if (id == 'laboral') 
    { 
      $("#aspectopersonal").css('display','none');
      $("#educativo").css('display','none'); 
      $("#sociales").css('display','none');  
      $("#laboral").css('display','block');

    }
    else if (id == 'sociales') 
    {
      $("#aspectopersonal").css('display','none');
      $("#educativo").css('display','none');
      $("#laboral").css('display','none');
      $("#sociales").css('display','block');

    }
}


function consultarEdadEntrevistado(fecha)
{
    

    
    if (fecha !== '0000-00-00') 
    {

        var values=fecha.split("-");

        var dia = values[2];

        var mes = values[1];

        var ano = values[0];


        // cogemos los valores actuales

        var fecha_hoy = new Date();

        var ahora_ano = fecha_hoy.getYear();

        var ahora_mes = fecha_hoy.getMonth()+1;

        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo

        var edad = (ahora_ano + 1900) - ano;

        if ( ahora_mes < mes )

        {
            edad--;
        }

        if ((mes == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }

        if (edad > 1900)
        {
            edad -= 1900;
        }
        

        $("#edadEntrevistaPregunta").val(edad);
    }
    else
    {
        alert("Debe llenar la fecha de nacimiento ");
        $("#edadEntrevistaPregunta").val('');
    }
}

