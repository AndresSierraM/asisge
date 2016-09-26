function validarFormulario(event)
{
    var route = "http://"+location.host+"/matrizlegal";
    var token = $("#token").val();
    var dato1 = document.getElementById('nombreMatrizLegal').value;
    var dato2 = document.getElementById('fechaElaboracionMatrizLegal').value;
    var dato3 = document.getElementById('origenMatrizLegal').value;
    var datoProceso = document.querySelectorAll("[name='TipoNormaLegal_idTipoNormaLegal[]']");
    var datoClasificacion = document.querySelectorAll("[name='ExpideNormaLegal_idExpideNormaLegal[]']");
    var dato4 = [];
    var dato5 = [];
    var dato6 = document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').value;

    
    var valor = '';
    var sw = true;
    for(var j=0,i=datoProceso.length; j<i;j++)
    {
        dato4[j] = datoProceso[j].value;
        dato5[j] = datoClasificacion[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                nombreMatrizLegal: dato1,
                fechaElaboracionMatrizLegal: dato2,
                origenMatrizLegal: dato3,
                TipoNormaLegal_idTipoNormaLegal: dato4,
                ExpideNormaLegal_idExpideNormaLegal: dato5,
                FrecuenciaMedicion_idFrecuenciaMedicion: dato6
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            var respuesta = JSON.stringify(msj.responseJSON);
            console.log(respuesta);
            if(typeof respuesta === "undefined")
            {
                sw = false;
                $("#msj").html('');
                $("#msj-error").fadeOut();
                $("#Grabar").click();
            }
            else
            {
                sw = true;
                respuesta = JSON.parse(respuesta);


                (typeof msj.responseJSON.nombreMatrizLegal === "undefined" ? document.getElementById('nombreMatrizLegal').style.borderColor = '' : document.getElementById('nombreMatrizLegal').style.borderColor = '#a94442');
                (typeof msj.responseJSON.origenMatrizLegal === "undefined" ? document.getElementById('origenMatrizLegal').style.borderColor = '' : document.getElementById('origenMatrizLegal').style.borderColor = '#a94442');
                (typeof msj.responseJSON.fechaElaboracionMatrizLegal === "undefined" ? document.getElementById('fechaElaboracionMatrizLegal').style.borderColor = '' : document.getElementById('fechaElaboracionMatrizLegal').style.borderColor = '#a94442');
                (typeof msj.responseJSON.FrecuenciaMedicion_idFrecuenciaMedicion === "undefined" ? document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').style.borderColor = '' : document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').style.borderColor = '#a94442');

                for(var j=0,i=datoProceso.length; j<i;j++)
                {
                    (typeof respuesta['TipoNormaLegal_idTipoNormaLegal'+j] === "undefined" ? document.getElementById('TipoNormaLegal_idTipoNormaLegal'+j).style.borderColor = '' : document.getElementById('TipoNormaLegal_idTipoNormaLegal'+j).style.borderColor = '#a94442');

                    (typeof respuesta['ExpideNormaLegal_idExpideNormaLegal'+j] === "undefined" ? document.getElementById('ExpideNormaLegal_idExpideNormaLegal'+j).style.borderColor = '' : document.getElementById('ExpideNormaLegal_idExpideNormaLegal'+j).style.borderColor = '#a94442');
                }
                $("#msj").html('Los campos bordeados en rojo son obligatorios.');
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}

function ejecutarInterface(ruta)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/importarMatrizLegal',
            type:  'post',
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                if(respuesta[0] == true)
                {
                    alert(respuesta[1]);
                    $("#modalMatrizLegal").modal("hide");
                }
                else
                {
                    $("#reporteErrorMatrizLegal").html(respuesta[1]);
                    $("#ModalErroresMatrizLegal").modal("show");
                }
            },
            error: function(xhr,err)
            { 
                console.log(err);
                alert("Error "+err);
            }
        });
    $("#dropzoneMatrizLegalArchivo .dz-preview").remove();
    $("#dropzoneMatrizLegalArchivo .dz-message").html('Seleccione o arrastre los archivos a subir.');
}