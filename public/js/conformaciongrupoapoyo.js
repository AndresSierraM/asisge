function validarFormulario(event)
{
    var route = "http://"+location.host+"/conformaciongrupoapoyo";
    var token = $("#token").val();
    var dato1 = document.getElementById('GrupoApoyo_idGrupoApoyo').value;
    var dato2 = document.getElementById('nombreConformacionGrupoApoyo').value;
    var dato3 = document.getElementById('fechaConformacionGrupoApoyo').value;
    var dato4 = document.getElementById('Tercero_idRepresentante').value;

    var datoJurado = document.querySelectorAll("[name='Tercero_idJurado[]']");
    var dato5 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoJurado.length; j<i;j++)
    {
        dato5[j] = datoJurado[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                GrupoApoyo_idGrupoApoyo: dato1,
                nombreConformacionGrupoApoyo: dato2,
                fechaConformacionGrupoApoyo: dato3,
                Tercero_idRepresentante: dato4, 
                Tercero_idJurado: dato5
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

                (typeof msj.responseJSON.GrupoApoyo_idGrupoApoyo === "undefined" ? document.getElementById('GrupoApoyo_idGrupoApoyo').style.borderColor = '' : document.getElementById('GrupoApoyo_idGrupoApoyo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreConformacionGrupoApoyo === "undefined" ? document.getElementById('nombreConformacionGrupoApoyo').style.borderColor = '' : document.getElementById('nombreConformacionGrupoApoyo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaConformacionGrupoApoyo === "undefined" ? document.getElementById('fechaConformacionGrupoApoyo').style.borderColor = '' : document.getElementById('fechaConformacionGrupoApoyo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idRepresentante === "undefined" ? document.getElementById('Tercero_idRepresentante').style.borderColor = '' : document.getElementById('Tercero_idRepresentante').style.borderColor = '#a94442');

                
                for(var j=0,i=datoJurado.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idJurado'+j] === "undefined" 
                        ? document.getElementById('Tercero_idJurado'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idJurado'+j).style.borderColor = '#a94442');
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

