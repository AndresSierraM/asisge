
function validarFormulario(event)
{                                          
            //                            se llama la vista del formulario
    var route = "http://"+location.host+"/evaluaciondesempenio";
    var token = $("#token").val();
    // Primer campo es el id del formulario
    var dato0 = document.getElementById('idEvaluacionDesempenio').value;  
    var dato1 = document.getElementById('Tercero_idEmpleado').value;
    var dato2 = document.getElementById('Cargo_idCargo').value;
    var dato3 = document.getElementById('Tercero_idResponsable').value;
    var dato4 = document.getElementById('fechaElaboracionEvaluacionDesempenio').value;
    

    

 // Variables de multiregistros 
    var EvaluacionResponsabilidad = document.querySelectorAll("[name='respuestaEvaluacionResponsabilidad[]']");
    var EvaluacionEducacion = document.querySelectorAll("[name='PerfilCargo_idAspirante_Educacion[]']"); 
    var EvaluacionFormacion = document.querySelectorAll("[name='PerfilCargo_idAspirante_Formacion[]']");
    var EvaluacionHabilidad = document.querySelectorAll("[name='PerfilCargo_idAspirante_Habilidad[]']");
    var EvaluacionPlanAccion = document.querySelectorAll("[name='actividadEvaluacionAccion[]']");

   
     

    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    var dato8 = [];
    var dato9= [];
 
    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= EvaluacionResponsabilidad.length; j<i;j++)
    {
        dato5[j] = EvaluacionResponsabilidad[j].value;
    }

    for(var j=0,i= EvaluacionEducacion.length; j<i;j++)
    {
        dato6[j] = EvaluacionEducacion[j].value;
    }
     for(var j=0,i= EvaluacionFormacion.length; j<i;j++)
    {
        dato7[j] = EvaluacionFormacion[j].value;
    }
     for(var j=0,i= EvaluacionHabilidad.length; j<i;j++)
    {
        dato8[j] = EvaluacionHabilidad[j].value;
    }
     for(var j=0,i= EvaluacionPlanAccion.length; j<i;j++)
    {
        dato9[j] = EvaluacionPlanAccion[j].value;
    }
  
    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEvaluacionDesempenio: dato0,
                Tercero_idEmpleado: dato1,
                Cargo_idCargo: dato2,
                Tercero_idResponsable: dato3,
                fechaElaboracionEvaluacionDesempenio: dato4, 
                respuestaEvaluacionResponsabilidad: dato5, 
                PerfilCargo_idAspirante_Educacion: dato6, 
                PerfilCargo_idAspirante_Formacion: dato7,
                PerfilCargo_idAspirante_Habilidad: dato8,
                actividadEvaluacionAccion: dato9,
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
               
                (typeof msj.responseJSON.Tercero_idEmpleado === "undefined" ? document.getElementById('Tercero_idEmpleado').style.borderColor = '' : document.getElementById('Tercero_idEmpleado').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Cargo_idCargo === "undefined" ? document.getElementById('Cargo_idCargo').style.borderColor = '' : document.getElementById('Cargo_idCargo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idResponsable === "undefined" ? document.getElementById('Tercero_idResponsable').style.borderColor = '' : document.getElementById('Tercero_idResponsable').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionEvaluacionDesempenio === "undefined" ? document.getElementById('fechaElaboracionEvaluacionDesempenio').style.borderColor = '' : document.getElementById('fechaElaboracionEvaluacionDesempenio').style.borderColor = '#a94442');

                
                
         
                for(var j=0,i=EvaluacionResponsabilidad.length; j<i;j++)
                {
                    (typeof respuesta['respuestaEvaluacionResponsabilidad'+j] === "undefined" 
                        ? document.getElementById('respuestaEvaluacionResponsabilidad'+j).style.borderColor = '' 
                        : document.getElementById('respuestaEvaluacionResponsabilidad'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=EvaluacionEducacion.length; j<i;j++)
                {
                    (typeof respuesta['PerfilCargo_idAspirante_Educacion'+j] === "undefined" ? document.getElementById('PerfilCargo_idAspirante_Educacion'+j).style.borderColor = '' : document.getElementById('PerfilCargo_idAspirante_Educacion'+j).style.borderColor = '#a94442');
                }

                 for(var j=0,i=EvaluacionFormacion.length; j<i;j++)
                {
                    (typeof respuesta['PerfilCargo_idAspirante_Formacion'+j] === "undefined" 
                        ? document.getElementById('PerfilCargo_idAspirante_Formacion'+j).style.borderColor = '' 
                        : document.getElementById('PerfilCargo_idAspirante_Formacion'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=EvaluacionHabilidad.length; j<i;j++)
                {
                    (typeof respuesta['PerfilCargo_idAspirante_Habilidad'+j] === "undefined" ? document.getElementById('PerfilCargo_idAspirante_Habilidad'+j).style.borderColor = '' : document.getElementById('PerfilCargo_idAspirante_Habilidad'+j).style.borderColor = '#a94442');
                }

                 for(var j=0,i=EvaluacionPlanAccion.length; j<i;j++)
                {
                    (typeof respuesta['actividadEvaluacionAccion'+j] === "undefined" 
                        ? document.getElementById('actividadEvaluacionAccion'+j).style.borderColor = '' 
                        : document.getElementById('actividadEvaluacionAccion'+j).style.borderColor = '#a94442');
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





function calificarhabilidad(idRequerido)
{
    // recibimos como parametro el id del campo de educacion requerida, con este tomamos el numero 
    // del registro para referirnos a los demas campos

    // si al id que recibimos, le quitamos el nombre, nos queda el numero del registro 
    var reg = idRequerido.replace('PerfilCargo_idAspirante_Habilidad', '') ;

    // con el numero de registro comparamos los valores de los 2 campos (solo de ese registro)
    if ($("#PerfilCargo_idRequerido_Habilidad"+reg).val() == $("#PerfilCargo_idAspirante_Habilidad"+reg).val())

    {
          $('#calificacionEvaluacionHabilidad'+reg+' option[value=\'100\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEvaluacionHabilidad'+reg+' option[value=\'0\']').prop('selected','selected');
    }
}
function calificarformacion(idRequerido)
{
    // recibimos como parametro el id del campo de educacion requerida, con este tomamos el numero 
    // del registro para referirnos a los demas campos

    // si al id que recibimos, le quitamos el nombre, nos queda el numero del registro 
    var reg = idRequerido.replace('PerfilCargo_idAspirante_Formacion', '') ;

    // con el numero de registro comparamos los valores de los 2 campos (solo de ese registro)
    if ($("#PerfilCargo_idRequerido_Formacion"+reg).val() == $("#PerfilCargo_idAspirante_Formacion"+reg).val())

    {
          $('#calificacionEvaluacionFormacion'+reg+' option[value=\'100\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEvaluacionFormacion'+reg+' option[value=\'0\']').prop('selected','selected');
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
          $('#calificacionEvaluacionEducacion'+reg+' option[value=\'100\']').prop('selected','selected');
    } 
    else 
    {
          $('#calificacionEvaluacionEducacion'+reg+' option[value=\'0\']').prop('selected','selected');
    }

}

function llenarEvaluacionHabilidad(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarEvaluacionHabilidad/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){
              
                // Limpiar el div de la multiregistro
                document.getElementById("EvaluacionHabilidad_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();
                var porcentaje = new Array();

                 $("#PesoPorcentajeHabilidad").val(respuesta[0]["porcentajeHabilidadCargo"]);
                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"]; 
                    porcentaje[i] = respuesta[i]["porcentajeCargoHabilidad"]; 

                    var valores = new Array(0,0,nombres[i],valor[i],porcentaje[i],0,'');  
                    window.parent.EvaluacionHabilidad.agregarCampos(valores,'A'); 
                 
                }  
               
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}
function llenarEvaluacionFormacion(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarEvaluacionFormacion/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){
              
                // Limpiar el div de la multiregistro
                document.getElementById("EvaluacionFormacion_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();
                var porcentaje = new Array();

                 $("#PesoPorcentajeFormacion").val(respuesta[0]["porcentajeFormacionCargo"]);
                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"]; 
                    porcentaje[i] = respuesta[i]["porcentajeCargoFormacion"]; 

                    var valores = new Array(0,0,nombres[i],valor[i],porcentaje[i],0,'');  
                    window.parent.EvaluacionFormacion.agregarCampos(valores,'A'); 
                 
                }  
               
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}
function llenarEvaluacionEducacion(idCargo)
{

    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarEvaluacionEducacion/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){
              
                // Limpiar el div de la multiregistro
                document.getElementById("EvaluacionEducacion_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();
                var porcentaje = new Array();

                 $("#PesoPorcentajeEducacion").val(respuesta[0]["porcentajeEducacionCargo"]);
                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"]; 
                    porcentaje[i] = respuesta[i]["porcentajeCargoEducacion"]; 

                    var valores = new Array(0,0,nombres[i],valor[i],porcentaje[i],0,'');  
                    window.parent.EvaluacionEducacion.agregarCampos(valores,'A'); 
                 
                }  
                
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}

function llenarResponsabilidadCargo(idCargo)
{
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idCargo': idCargo},
            url:   'http://'+location.host+'/llenarResponsabilidadCargo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                // Limpiar el div de la multiregistro
                document.getElementById("responsabilidades_Modulo").innerHTML = '';
                var valor = new Array();
                var nombres = new Array();

                $("#PesoPorcentajeResponsabilidad").val(respuesta[0]["porcentajeResponsabilidadCargo"]);
                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idCargoResponsabilidad"];
                    nombres[i] = respuesta[i]["descripcionCargoResponsabilidad"];
                    
                    
                    var valores = new Array(0,0,nombres[i],valor[i],'');
                    window.parent.EvaluacionResponsabilidad.agregarCampos(valores,'A'); 

                }  
               
            },

            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}

function llenarCargo(idTercero)
{
        var token = document.getElementById('token').value;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idTercero': idTercero},
                url:   'http://'+location.host+'/llenarEvaluacionDesempenioCargo/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    //lo que se si el destino devuelve algo
        
                    $("#nombreCargo").val(respuesta['nombreCargo']);  
                    $("#Cargo_idCargo").val(respuesta['idCargo']); 
                                                                        // Se trae el id y el nombre 
                    llenarResponsabilidadCargo(respuesta['idCargo']);
                    llenarEvaluacionEducacion(respuesta['idCargo']);
                    llenarEvaluacionFormacion(respuesta['idCargo']);
                    llenarEvaluacionHabilidad(respuesta['idCargo']);

                    

                },
                error:    function(xhr,err){ 
                    alert("Error");
                }
            });

}

function mostrarDivGenerales(id)
 {
 
  if (id == 'Habilidadesactitudinales') 
  {
    $("#Habilidadesactitudinales").css('display', 'block');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'none');
    $("#observacion").css('display', 'none');
   

    
  }


  else if (id == 'Responsabilidades')
  {

    $("#Habilidadesactitudinales").css('display', 'none');  
    $("#Responsabilidades").css('display', 'block');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'none');
    $("#observacion").css('display', 'none');
   
  }

  else if (id == 'Habilidades')
  {

    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'block');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'none');
    $("#observacion").css('display', 'none');
   
  }

  else if (id == 'Resultado')
  {
    
    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'block');
    $("#planaccion").css('display', 'none');
    $("#observacion").css('display', 'none');
   
  }
    else if (id == 'planaccion')
  {
    
    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'block');
    $("#observacion").css('display', 'none');
    

  }
    else if (id == 'observacion')
  {
    
    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'none');
    $("#observacion").css('display', 'block');
    

  }
   

}


