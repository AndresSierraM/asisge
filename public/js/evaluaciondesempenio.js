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
   

    
  }


  else if (id == 'Responsabilidades')
  {

    $("#Habilidadesactitudinales").css('display', 'none');  
    $("#Responsabilidades").css('display', 'block');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'none');
   
  }

  else if (id == 'Habilidades')
  {

    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'block');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'none');
   
  }

  else if (id == 'Resultado')
  {
    
    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'block');
    $("#planaccion").css('display', 'none');
   
  }
    else if (id == 'planaccion')
  {
    
    $("#Habilidadesactitudinales").css('display', 'none');
    $("#Responsabilidades").css('display', 'none');
    $("#Habilidades").css('display', 'none');
    $("#Resultado").css('display', 'none');
    $("#planaccion").css('display', 'block');

  }
   

}


