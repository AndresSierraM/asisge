function llenarInformacionCandidato(IdTerceroEmpleado)
{
       var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'IdTerceroEmpleado': IdTerceroEmpleado.value},
            url:   'http://'+location.host+'/llenarInformacionCandidato/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                // Se reemplaza el id con blanco para tener el registro 
                reg = IdTerceroEmpleado.id.replace('Tercero_idInscrito','');

                // Se valida que el cargo que se esta consultando si tenga valor, si tiene valor devuelve el valor, de no tener un valor devuelve un mensaje en el campo
                if (respuesta[0]['Cargo_idCargo'] == '' || respuesta[0]['Cargo_idCargo'] == '' ||  respuesta[0]['Cargo_idCargo'] == null) 
                    {
                        $("#nombreCargo"+reg).val('No tiene cargo asociado');
                    }
                else
                    {                                     
                        $("#nombreCargo"+reg).val(respuesta[0]['nombreCargo']);
                    }

                // Se valida que el Centro de costo que se esta consultando si tenga valor, si tiene valor devuelve el valor, de no tener un valor devuelve un mensaje en el campo
                if (respuesta[0]['CentroCosto_idCentroCosto'] == '' || respuesta[0]['CentroCosto_idCentroCosto'] == '' ||  respuesta[0]['CentroCosto_idCentroCosto'] == null)
                    {
                        $("#centrocosto"+reg).val('No tiene centro de costo asociado');
                    }
                else
                    {
                        $("#centrocosto"+reg).val(respuesta[0]['nombreCentroCosto']);
                    }                         
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}



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
    var dato8 = document.getElementById('Tercero_idGerente').value;

    var datoCandidato = document.querySelectorAll("[name='Tercero_idCandidato[]']");
    var dato9 = [];

    var datonombrado = document.querySelectorAll("[name='nombradoPorConformacionGrupoApoyoComite[]']");
    var dato10 = [];

    var datoinscrito = document.querySelectorAll("[name='Tercero_idInscrito[]']");
    var dato11 = [];


    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoJurado.length; j<i;j++)
    {
        dato5[j] = datoJurado[j].value;
    }

    for(var j=0,i=datoCandidato.length; j<i;j++)
    {
        dato9[j] = datoCandidato[j].value;
    }


    for(var j=0,i=datonombrado.length; j<i;j++)
    {
        dato10[j] = datonombrado[j].value;
    }

    for(var j=0,i=datoinscrito.length; j<i;j++)
    {
        dato11[j] = datoinscrito[j].value;
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
                Tercero_idJurado: dato5,
                Tercero_idGerente: dato8,
                Tercero_idCandidato: dato9,
                nombradoPorConformacionGrupoApoyoComite: dato10,
                Tercero_idInscrito: dato11

  
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

                (typeof msj.responseJSON.Tercero_idGerente === "undefined" ? document.getElementById('Tercero_idGerente').style.borderColor = '' : document.getElementById('Tercero_idGerente').style.borderColor = '#a94442');
                
                for(var j=0,i=datoJurado.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idJurado'+j] === "undefined" 
                        ? document.getElementById('Tercero_idJurado'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idJurado'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoCandidato.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idCandidato'+j] === "undefined" 
                        ? document.getElementById('Tercero_idCandidato'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idCandidato'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datonombrado.length; j<i;j++)
                {
                    (typeof respuesta['nombradoPorConformacionGrupoApoyoComite'+j] === "undefined"
                        ? document.getElementById('nombradoPorConformacionGrupoApoyoComite'+j).style.borderColor = '' 
                        : document.getElementById('nombradoPorConformacionGrupoApoyoComite'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoinscrito.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idInscrito'+j] === "undefined"
                        ? document.getElementById('Tercero_idInscrito'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idInscrito'+j).style.borderColor = '#a94442');
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

function firmarGrupoApoyo(idGrupo)
{
        var lastIdx = null;
        window.parent.$("#tconformaciongrupoapoyoselec").DataTable().ajax.url("http://"+location.host+"/datosConformacionGrupoApoyoSelect?idGrupo="+idGrupo).load();
         // Abrir modal
        window.parent.$("#modalConformacionGrupoApoyo").modal()

        $("a.toggle-vis").on( "click", function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr("data-column") );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        window.parent.$("#tconformaciongrupoapoyoselec tbody").on( "mouseover", "td", function () 
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
        window.parent.$("#tconformaciongrupoapoyoselec tfoot th").each( function () 
        {
            var title = window.parent.$("#tconformaciongrupoapoyoselec thead th").eq( $(this).index() ).text();
            $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
        });
     
        // DataTable
        var table = window.parent.$("#tconformaciongrupoapoyoselec").DataTable();
     
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

        $("#tconformaciongrupoapoyoselec tbody").on( "click", "tr", function () 
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
                $("#idGrupoApoyo").val(datos[0][1]);
                $("#idJurado").val(datos[0][2]);
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

        var idGrupoApoyo = $("#idGrupoApoyo").val();
        var idJurado = $("#idJurado").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idGrupoApoyo' : idGrupoApoyo, 'idJurado': idJurado, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaConformacionGrupoApoyo/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}