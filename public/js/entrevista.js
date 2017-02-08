function calificacionEduacionEntrevista()
{
    // Se crea una variable para que inicie en 0 
    var calificarE = 0;
    var resultado = 0;
    var valor1 = 100;
    var valor2 = 5;

    
    for (var i = 0; i < Educacionentrevista.contador; i++) {
        calificarE += parseFloat($('#porcentajeCargoEducacion'+[i]).val() * parseFloat($('#calificacionEntrevistaEducacion'+[i]).val()));
        
        
    }

   isNaN(resultado = calificarE/valor1);

   
$("#calificacionEducacionEntrevista").val(resultado);
}




function validarFormulario(event)
{
    var route = "http://"+location.host+"/entrevista";
    var token = $("#token").val();
    var dato0 = document.getElementById('idEntrevista').value;
    var dato1 = document.getElementById('documentoAspiranteEntrevista').value;
    var dato2 = document.getElementById('estadoEntrevista').value;
    var dato3 = document.getElementById('nombre1AspiranteEntrevista').value;
    var dato4 = document.getElementById('apellido1AspiranteEntrevista').value;
    var dato5 = document.getElementById('Tercero_idEntrevistador').value;
    var dato6 = document.getElementById('fechaEntrevista').value;
    var dato7 = document.getElementById('Cargo_idCargo').value;
    var dato8 = document.getElementById('experienciaAspiranteEntrevista').value;

 
    var EntrevistaHijos = document.querySelectorAll("[name='nombreEntrevistaHijo[]']");
    var RelacionFamiliar = document.querySelectorAll("[name='parentescoEntrevistaRelacionFamiliar[]']"); 
    var CompetenciaPregunta = document.querySelectorAll("[name='CompetenciaPregunta_idCompetenciaPregunta[]']");
    var EntrevistaFormacion = document.querySelectorAll("[name='calificacionEntrevistaFormacion[]']"); 
    var EntrevistaEducacion = document.querySelectorAll("[name='calificacionEntrevistaEducacion[]']");
    var EntrevistaHabilidad = document.querySelectorAll("[name='calificacionEntrevistaHabilidad[]']"); 

    var dato9 = [];
    var dato10 = [];
    var dato11 = [];
    var dato12 = [];
    var dato13= [];
    var dato14 = [];
    
    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= EntrevistaHijos.length; j<i;j++)
    {
        dato9[j] = EntrevistaHijos[j].value;
    }

    for(var j=0,i= RelacionFamiliar.length; j<i;j++)
    {
        dato10[j] = RelacionFamiliar[j].value;
    }
     for(var j=0,i= CompetenciaPregunta.length; j<i;j++)
    {
        dato11[j] = CompetenciaPregunta[j].value;
    }
     for(var j=0,i= EntrevistaFormacion.length; j<i;j++)
    {
        dato12[j] = EntrevistaFormacion[j].value;
    }
     for(var j=0,i= EntrevistaEducacion.length; j<i;j++)
    {
        dato13[j] = EntrevistaEducacion[j].value;
    }
     for(var j=0,i= EntrevistaHabilidad.length; j<i;j++)
    {
        dato14[j] = EntrevistaHabilidad[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEntrevista: dato0,
                documentoAspiranteEntrevista: dato1,
                estadoEntrevista: dato2,
                nombre1AspiranteEntrevista: dato3,
                apellido1AspiranteEntrevista: dato4, 
                Tercero_idEntrevistador: dato5, 
                fechaEntrevista: dato6, 
                Cargo_idCargo: dato7,
                experienciaAspiranteEntrevista: dato8,
                nombreEntrevistaHijo: dato9,
                parentescoEntrevistaRelacionFamiliar: dato10,
                CompetenciaPregunta_idCompetenciaPregunta: dato11,
                calificacionEntrevistaFormacion: dato12,
                calificacionEntrevistaEducacion: dato13,
                calificacionEntrevistaHabilidad: dato14,
                // solo se modifica los campos del data
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');

        },
        error:function(msj){
            var mensaje = '';
            var respuesta = JSON.stringify(msj.responseJSON); 
            if(typeof respuesta === "undefined")
            {
                sw = false;
                $("#msj").html('');
                $("#msj-error").fadeOut();

            }
            else
            {
                sw = true;
                respuesta = JSON.parse(respuesta);
               
                (typeof msj.responseJSON.documentoAspiranteEntrevista === "undefined" ? document.getElementById('documentoAspiranteEntrevista').style.borderColor = '' : document.getElementById('documentoAspiranteEntrevista').style.borderColor = '#a94442');

                (typeof msj.responseJSON.estadoEntrevista === "undefined" ? document.getElementById('estadoEntrevista').style.borderColor = '' : document.getElementById('estadoEntrevista').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombre1AspiranteEntrevista === "undefined" ? document.getElementById('nombre1AspiranteEntrevista').style.borderColor = '' : document.getElementById('nombre1AspiranteEntrevista').style.borderColor = '#a94442');

                (typeof msj.responseJSON.apellido1AspiranteEntrevista === "undefined" ? document.getElementById('apellido1AspiranteEntrevista').style.borderColor = '' : document.getElementById('apellido1AspiranteEntrevista').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idEntrevistador === "undefined" ? document.getElementById('Tercero_idEntrevistador').style.borderColor = '' : document.getElementById('Tercero_idEntrevistador').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaEntrevista === "undefined" ? document.getElementById('fechaEntrevista').style.borderColor = '' : document.getElementById('fechaEntrevista').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Cargo_idCargo === "undefined" ? document.getElementById('Cargo_idCargo').style.borderColor = '' : document.getElementById('Cargo_idCargo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.experienciaAspiranteEntrevista === "undefined" ? document.getElementById('experienciaAspiranteEntrevista').style.borderColor = '' : document.getElementById('experienciaAspiranteEntrevista').style.borderColor = '#a94442');

                
         
                for(var j=0,i=EntrevistaHijos.length; j<i;j++)
                {
                    (typeof respuesta['nombreEntrevistaHijo'+j] === "undefined" 
                        ? document.getElementById('nombreEntrevistaHijo'+j).style.borderColor = '' 
                        : document.getElementById('nombreEntrevistaHijo'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=RelacionFamiliar.length; j<i;j++)
                {
                    (typeof respuesta['parentescoEntrevistaRelacionFamiliar'+j] === "undefined" ? document.getElementById('parentescoEntrevistaRelacionFamiliar'+j).style.borderColor = '' : document.getElementById('parentescoEntrevistaRelacionFamiliar'+j).style.borderColor = '#a94442');
                }

                 for(var j=0,i=CompetenciaPregunta.length; j<i;j++)
                {
                    (typeof respuesta['Proceso_idResponsable'+j] === "undefined" 
                        ? document.getElementById('CompetenciaPregunta_idCompetenciaPregunta'+j).style.borderColor = '' 
                        : document.getElementById('CompetenciaPregunta_idCompetenciaPregunta'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=EntrevistaFormacion.length; j<i;j++)
                {
                    (typeof respuesta['calificacionEntrevistaFormacion'+j] === "undefined" ? document.getElementById('calificacionEntrevistaFormacion'+j).style.borderColor = '' : document.getElementById('calificacionEntrevistaFormacion'+j).style.borderColor = '#a94442');
                }

                 for(var j=0,i=EntrevistaEducacion.length; j<i;j++)
                {
                    (typeof respuesta['calificacionEntrevistaEducacion'+j] === "undefined" 
                        ? document.getElementById('calificacionEntrevistaEducacion'+j).style.borderColor = '' 
                        : document.getElementById('calificacionEntrevistaEducacion'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=EntrevistaHabilidad.length; j<i;j++)
                {
                    (typeof respuesta['calificacionEntrevistaHabilidad'+j] === "undefined" ? document.getElementById('calificacionEntrevistaHabilidad'+j).style.borderColor = '' : document.getElementById('calificacionEntrevistaHabilidad'+j).style.borderColor = '#a94442');
                }

                var mensaje = 'Por favor verifique los siguientes valores <br><ul>';
                $.each(respuesta,function(index, value){
                    mensaje +='<li>' +value+'</li><br>';
                });
                mensaje +='</ul>';
               
                $("#msj").html(mensaje);
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}

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



function calificarHabilidad(idRequerido)
{

  // recibimos como parametro el id del campo de educacion requerida, con este tomamos el numero 
    // del registro para referirnos a los demas campos

    // si al id que recibimos, le quitamos el nombre, nos queda el numero del registro 
    var reg = idRequerido.replace('PerfilCargo_idAspirante_Habilidad', '') ;

    // con el numero de registro comparamos los valores de los  campos (solo de ese registro)
    if ($("#PerfilCargo_idRequerido_Habilidad"+reg).val() == $("#PerfilCargo_idAspirante_Habilidad"+reg).val())

    {
          $('#calificacionEntrevistaHabilidad'+reg+' option[value=\'5\']').prop('selected','selected');

    } 
    else 
    {
          $('#calificacionEntrevistaHabilidad'+reg+' option[value=\'1\']').prop('selected','selected');
    }
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
          $('#calificacionEntrevistaFormacion'+reg+' option[value=\'5\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEntrevistaFormacion'+reg+' option[value=\'1\']').prop('selected','selected');
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
          $('#calificacionEntrevistaEducacion'+reg+' option[value=\'5\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEntrevistaEducacion'+reg+' option[value=\'1\']').prop('selected','selected');
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

function llenarHabilidadCargo(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarHabilidadCargo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){
              
                // Limpiar el div de la multiregistro
                document.getElementById("HabilidadEntrevista_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();
                var porcentaje = new Array();

                
                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"]; 
                    porcentaje[i] = respuesta[i]["porcentajeCargoHabilidad"]; 

                    var valores = new Array(0,nombres[i],valor[i],porcentaje[i],0,0,0);  
                    window.parent.Habilidadentrevista.agregarCampos(valores,'A'); 
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

