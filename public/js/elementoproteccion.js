var Atributos = function(nombreObjeto, nombreContenedor, nombreDiv){

    this.nombre = nombreObjeto;
    this.contenedor = nombreContenedor;
    this.contenido = nombreDiv;
    this.contador = 0;
    this.campos = new Array();
    this.etiqueta = new Array();
    this.tipo = new Array();
    this.estilo = new Array();
    this.clase = new Array();
    this.sololectura = new Array();
    this.eventochange = new Array();
    this.idElementoProteccion = new Array();
    this.nombreElementoProteccion = new Array();
    this.valorOpcion = new Array();

};

Atributos.prototype.agregarCampos = function(datos, tipo,valorOpcion){ 

    var valor;
    if(tipo == 'A')
       valor = datos;
    else
        valor = $.parseJSON(datos);
    
    var espacio = document.getElementById(this.contenedor);
    var caneca = document.createElement('div');
    var img = document.createElement('i');
    var div = document.createElement('div');
    div.id = this.contenido+this.contador;
    div.setAttribute("width", '100%');


    for (var i = 0,  e = this.campos.length; i < e ; i++)
    {
        if  (this.etiqueta[i] == 'input')  
            {
                var input = document.createElement('input');
                input.type =  this.tipo[i];
                input.id =  this.campos[i] + this.contador;
                input.name =  this.campos[i]+'[]';

                input.value = valor[(tipo == 'A' ? i : this.campos[i])];
                input.setAttribute("class", this.clase[i]);
                input.setAttribute("style", this.estilo[i]);

                div.appendChild(input);

            }

        else if (this.etiqueta[i] == 'select')  
            {
                var select = document.createElement('select');
                var option = '';
                select.id =  this.campos[i] + this.contador;
                select.name =  this.campos[i]+'[]';
                select.setAttribute("style", this.estilo[i]);
                select.setAttribute("class", this.clase[i]);
                select.setAttribute("onchange", this.eventochange[i]);


                option = document.createElement('option');
                option.value = ''; //El id del select en este caso ('Seleccione una opcion') esta vacío
                option.text = 'Seleccione una opcion';
                option.selected = true;
                select.appendChild(option);
            
                for(var j=0,k=this.idElementoProteccion.length;j<k;j++)
                    {
                        option = document.createElement('option');
                        option.value = this.idElementoProteccion[j];
                        option.text = this.nombreElementoProteccion[j];

                        option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.idElementoProteccion[j] ? true : false);
                        select.appendChild(option);
                        //En el momento de editar
                        //Consulta si el campo idElementoProteccion esta lleno (===true) y si es así le envía a descripcion su valor
                        if((valor[(tipo == 'A' ? i : this.campos[i])] == this.idElementoProteccion[j]) === true)
                        {
                            llenarDescripcion(this.idElementoProteccion[j], (this.campos[i] + this.contador));
                        }

                    }
                        div.appendChild(select);
            } 
    }
    




    caneca.id = 'eliminarRegistro'+ this.contador;
    caneca.setAttribute('onclick',this.nombre+'.borrarCampos('+this.contenido+this.contador+')');
    caneca.setAttribute("class","col-md-1");
    caneca.setAttribute("style","width:40px; height: 35px;");
    img.setAttribute("class","glyphicon glyphicon-trash");
    caneca.appendChild(img);
    div.appendChild(caneca);
    espacio.appendChild(div);

    this.contador++;

    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
}

Atributos.prototype.borrarCampos = function(elemento){

    aux = elemento.parentNode;
    aux.removeChild(elemento);

}

Atributos.prototype.cambiarCheckbox = function(campo, registro)
{
    //console.log(campo+' ----> '+registro);
    document.getElementById(campo+registro).value = document.getElementById(campo+"C"+registro).checked ? 1 : 0;
}

function llenarCargo(idTercero)
{
         var token = document.getElementById('token').value;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idTercero': idTercero},
                url:   'http://localhost:8000/llenarCargo/',
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
                url:   'http://localhost:8000/llenarDescripcion/',
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