function llamarVistas(id, valor) 
{

    
    var select = document.getElementById('SistemaInformacion_idSistemaInformacion').value;
    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/llamarVistas',
        data:{idSistemaInformacion: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {

            $('#vistaInforme').html('');
            var select = document.getElementById('vistaInforme');

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione';
            select.appendChild(option);
            for (var i = 0;  i < data.length; i++) 
            {
                option = document.createElement('option');
                option.value = data[i]['TABLE_NAME'];
                option.text = (data[i]['TABLE_COMMENT'] != '' ? data[i]['TABLE_COMMENT'] : data[i]['TABLE_NAME']);

                option.selected = (valor == data[i]['TABLE_NAME'] ? true : false);

                select.appendChild(option);
            }
            $("#vistaInforme").trigger("chosen:updated");

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: ' +err);
        }
    });
}


function abrirModalCampos(idiframe, ruta)
{
    var $iframe = $('#' + idiframe);
    if ( $iframe.length ) {
        $iframe.attr('src',ruta);   
        $('#ModalCampos').modal('show');
    }
}


function adicionarRegistros(nombreTabla, datos)
{

    switch(nombreTabla)  
    {
        case 'tinformecampo':

           for (var i = 0; i < datos.length; i++) 
            {

                var valores = new Array(0, datos[i][1], 0,0,0, datos[i][0],  'I','S','','I', '','',10,0);

                window.parent.columnas.agregarCampos(valores,'A');  
            }
            $('#ModalCampos').modal('hide');
        break;

    }



}
