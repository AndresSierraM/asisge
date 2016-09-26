function validarFormulario(event)
{
    var route = "http://"+location.host+"/entregaelementoproteccion";
    var token = $("#token").val();
    var dato0 = document.getElementById('idEntregaElementoProteccion').value;
    var dato1 = document.getElementById('Tercero_idTercero').value;
    var dato2 = document.getElementById('fechaEntregaElementoProteccion').value;
    var datoElemento = document.querySelectorAll("[name='ElementoProteccion_idElementoProteccion[]']");
    var datoCantidad = document.querySelectorAll("[name='cantidadEntregaElementoProteccionDetalle[]']");
    var dato3 = [];
    var dato4 = [];

    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoElemento.length; j<i;j++)
    {
        dato3[j] = datoElemento[j].value;
    }

    for(var j=0,i=datoCantidad.length; j<i;j++)
    {
        dato4[j] = datoCantidad[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEntregaElementoProteccion: dato0,
                Tercero_idTercero: dato1,
                fechaEntregaElementoProteccion: dato2,
                ElementoProteccion_idElementoProteccion: dato3,
                cantidadEntregaElementoProteccionDetalle: dato4, 
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

                (typeof msj.responseJSON.Tercero_idTercero === "undefined" ? document.getElementById('Tercero_idTercero').style.borderColor = '' : document.getElementById('Tercero_idTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaEntregaElementoProteccion === "undefined" ? document.getElementById('fechaEntregaElementoProteccion').style.borderColor = '' : document.getElementById('fechaEntregaElementoProteccion').style.borderColor = '#a94442');


                for(var j=0,i=datoElemento.length; j<i;j++)
                {
                    (typeof respuesta['ElementoProteccion_idElementoProteccion'+j] === "undefined" 
                        ? document.getElementById('ElementoProteccion_idElementoProteccion'+j).style.borderColor = '' 
                        : document.getElementById('ElementoProteccion_idElementoProteccion'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoCantidad.length; j<i;j++)
                {
                    (typeof respuesta['cantidadEntregaElementoProteccionDetalle'+j] === "undefined" ? document.getElementById('cantidadEntregaElementoProteccionDetalle'+j).style.borderColor = '' : document.getElementById('cantidadEntregaElementoProteccionDetalle'+j).style.borderColor = '#a94442');
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



function llenarCargo(idTercero)
{
         var token = document.getElementById('token').value;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idTercero': idTercero},
                url:   'http://'+location.host+'/llenarCargo/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    //lo que se si el destino devuelve algo
                    $("#nombreCargo").val(respuesta); //Al input nombreCargo le envío la respuesta de la consulta
                                                      //realizada en llenarCargo
                },
                error:    function(xhr,err){ 
                    alert("Error");
                }
            });
}

function llenarDescripcion(idElementoProteccion,nombreCampo)
{
    var registro = nombreCampo.substring(39); //Le quito la palabra 'ElementoProteccion_idElementoProteccion'y solo envío el número del registro
    var token = document.getElementById('token').value; 

    //Pregunto si el idElemento es diferente a vacío y de ser así lleno el campo descripcion y si no lo es
    //este quedará vacío
    if(idElementoProteccion > 0 && idElementoProteccion != '')
    {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'ElementoProteccion_idElementoProteccion': idElementoProteccion},
                url:   'http://'+location.host+'/llenarDescripcion/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    //lo que se si el destino devuelve algo
                    $("#descripcionElementoProteccion"+registro).val(respuesta);
                },
                error:    function(xhr,err){ 
                    alert("Error");
                }
            });
    }
    else
    {
        $("#descripcionElementoProteccion"+registro).val('');
    }
}

function firmarEntregaElemento(idElemento)
{
        var lastIdx = null;
        window.parent.$("#tentregaelementoselect").DataTable().ajax.url("http://"+location.host+"/datosEntregaElementoProteccionSelect?idElemento="+idElemento).load();
         // Abrir modal
        window.parent.$("#modalEntregaElemento").modal()

        $("a.toggle-vis").on( "click", function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr("data-column") );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        window.parent.$("#tentregaelementoselect tbody").on( "mouseover", "td", function () 
        {
            var colIdx = table.cell(this).index().column;

            if ( colIdx !== lastIdx ) {
                $( table.cells().nodes() ).removeClass( "highlight" );
                $( table.column( colIdx ).nodes() ).addClass( "highlight" );
            }
        }).on( "mouseleave", function () {
            $( table.cells().nodes() ).removeClass( "highlight" );
        });


        // Setup - add a text input to each footer cell
        window.parent.$("#tentregaelementoselect tfoot th").each( function () 
        {
            var title = window.parent.$("#tentregaelementoselect thead th").eq( $(this).index() ).text();
            $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
        });
     
        // DataTable
        var table = window.parent.$("#tentregaelementoselect").DataTable();
     
        // Apply the search
        table.columns().every( function () 
        {
            var that = this;
     
            $( "input", this.footer() ).on( "blur change", function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        })

        $("#tentregaelementoselect tbody").on( "click", "tr", function () 
        {
        if ( $(this).hasClass("selected") ) {
            $(this).removeClass("selected");
        }
        else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }

        var datos = table.rows('.selected').data();

            if (datos.length > 0) 
            {
                $("#idEmpleado").val(datos[0][1]);
                signaturePad.clear();
                mostrarFirma();
            }

        });
}

function cerrarDivFirma()
{
    document.getElementById("signature-pad").style.display = "none";
}

function actualizarFirma()
{
    if (signaturePad.isEmpty()) 
    {
        alert("Por Favor Registre Su Firma.");
    } else 
    {
        //window.open(signaturePad.toDataURL());
        reg = '';
        if(document.getElementById("signature-reg").value != 'undefined')
            reg = document.getElementById("signature-reg").value;
        

        document.getElementById("firma"+reg).src = signaturePad.toDataURL() ;
        document.getElementById("firmabase64"+reg).value = signaturePad.toDataURL();
        mostrarFirma();

        var idEmpleado = $("#idEmpleado").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idEmpleado' : idEmpleado, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaEntregaElementoProteccion/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}