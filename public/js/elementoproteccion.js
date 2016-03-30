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