
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

                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"];
                    
                    var valores = new Array(0,valor[i],nombres[i],'',1);
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

                for (var i = 0; i < respuesta.length; i++) 
                {
                    valor[i] = respuesta[i]["idPerfilCargo"];
                    nombres[i] = respuesta[i]["nombrePerfilCargo"]; 
                    var valores = new Array(0,nombres[i],valor[i],0,0);    
                    alert(valores);
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
