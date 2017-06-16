function validarFormulario(event)
{
    var route = "http://"+location.host+"/lineaproducto";
    var token = $("#token").val();
    var dato0 = document.getElementById('idLineaProducto').value;
    var dato1 = document.getElementById('codigoLineaProducto').value;
    var dato2 = document.getElementById('nombreLineaProducto').value;
 
    
    var NombreSublinea = document.querySelectorAll("[name='nombreSublineaProducto[]']");
    var CodigoSublinea = document.querySelectorAll("[name='codigoSublineaProducto[]']");


    var dato3 = [];
    var dato4 = [];

    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= NombreSublinea.length; j<i;j++)
    {
        dato3[j] = NombreSublinea[j].value;
    }

    for(var j=0,i= CodigoSublinea.length; j<i;j++)
    {
        dato4[j] = CodigoSublinea[j].value;
    }



    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idLineaProducto: dato0,
                codigoLineaProducto: dato1,
                nombreLineaProducto: dato2,
                nombreSublineaProducto: dato3,
                codigoSublineaProducto: dato4,
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
               
                (typeof msj.responseJSON.codigoLineaProducto === "undefined" ? document.getElementById('codigoLineaProducto').style.borderColor = '' : document.getElementById('codigoLineaProducto').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreLineaProducto === "undefined" ? document.getElementById('nombreLineaProducto').style.borderColor = '' : document.getElementById('nombreLineaProducto').style.borderColor = '#a94442');

                
         
                for(var j=0,i=NombreSublinea.length; j<i;j++)
                {
                    (typeof respuesta['nombreSublineaProducto'+j] === "undefined" 
                        ? document.getElementById('nombreSublineaProducto'+j).style.borderColor = '' 
                        : document.getElementById('nombreSublineaProducto'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=CodigoSublinea.length; j<i;j++)
                {
                    (typeof respuesta['codigoSublineaProducto'+j] === "undefined" 
                        ? document.getElementById('codigoSublineaProducto'+j).style.borderColor = '' 
                        : document.getElementById('codigoSublineaProducto'+j).style.borderColor = '#a94442');
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