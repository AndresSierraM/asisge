
function colorTarea(valorTarea, valorCumplido)
{

    icono = '';        
    if(valorTarea != valorCumplido && valorCumplido != 0)
    {
     
        tool = 'Tareas Pendientes : '+valorTarea+'  /  Tareas Realizadas : '+valorCumplido;
        icono =   '<a href="#" data-toggle="tooltip" data-placement="right" title="'+tool+'">'+
                  '     <img src="http://'+location.host+'/images/iconosmenu/Amarillo.png"  width="30">'+
                  '</a>'+
                  '<label>'+(valorCumplido / (valorTarea == 0 ? 1 : valorTarea) * 100)+'%</label>';      
    }else if(valorTarea == valorCumplido && valorTarea != 0)
    {
        icono = '<img src="http://'+location.host+'/images/iconosmenu/Verde.png" width="30">';
    }
    else if(valorTarea > 0 && valorCumplido == 0)
    {
        icono = '<img src="http://'+location.host+'/images/iconosmenu/Rojo.png" width="30">';       
    }

    return icono;
}


function consultarPlanTrabajo(idCompania, proceso, titulo)
{
    var token = document.getElementById('token').value;
    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:   'http://'+location.host+'/'+proceso,
        data:{idCompania: idCompania},
        type:  'post',
        beforeSend: function(){
            },
        success: function(data){
       

            informes =
                    '            <table  class="table table-striped table-bordered table-hover" style="width:100%;" >'+
                    '                <thead class="thead-inverse">'+
                    '                    <tr class="table-info">'+
                    '                        <th scope="col" width="30%">&nbsp;</th>'+
                    '                        <th >Enero</th>'+
                    '                        <th >Febrero</th>'+
                    '                        <th >Marzo</th>'+
                    '                        <th >Abril</th>'+
                    '                        <th >Mayo</th>'+
                    '                        <th >Junio</th>'+
                    '                        <th >Julio</th>'+
                    '                        <th >Agosto</th>'+
                    '                        <th >Septiembre</th>'+
                    '                        <th >Octubre</th>'+
                    '                        <th >Noviembre</th>'+
                    '                        <th >Diciembre</th>'+
                    '                        <th >Presupuesto</th>'+
                    '                        <th >Costo Real</th>'+
                    '                        <th >Cumplimiento</th>'+
                    '                        <th >Responsable</th>'+
                    '                    </tr>'+
                    '                </thead>'+
                    '                <tbody>';

            for(var i=0; i < data.length; i++)
            {
                    
                informes += '<tr align="center">'+
                    '<th scope="row"><a href="javascript:abrirModulo(\''+proceso+'\', '+data[i]["idTarea"]+');">'+data[i]["descripcionTarea"]+'</a></th>'+
                    '<td>'+colorTarea(data[i]["EneroT"],data[i]["EneroC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["FebreroT"],data[i]["FebreroC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["MarzoT"],data[i]["MarzoC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["AbrilT"],data[i]["AbrilC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["MayoT"],data[i]["MayoC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["JunioT"],data[i]["JunioC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["JulioT"],data[i]["JulioC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["AgostoT"],data[i]["AgostoC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["SeptiembreT"],data[i]["SeptiembreC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["OctubreT"],data[i]["OctubreC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["NoviembreT"],data[i]["NoviembreC"])+'</td>'+
                    '<td>'+colorTarea(data[i]["DiciembreT"],data[i]["DiciembreC"])+'</td>'+
                    '<td>&nbsp;</td>'+
                    '<td>&nbsp;</td>'+
                    '<td>&nbsp;</td>'+
                    '<td>&nbsp;</td>'+
                '</tr>';
            }

            informes += '</tbody>'+
                    '</table>';

            
            $(".containerPlanTrabajo").html(informes) ;
            $(".PlanTrabajo .modal-title div").html(titulo);
            $('.PlanTrabajo').css('display', 'block');
            
        },
        error:    function(xhr,err){
            alert('Se ha producido un error: ' +err);
        }
    });
}

function abrirModulo(proceso, idTarea)
{
    
    switch(proceso)
    {
        case 'dashboardConsultarProgramas':
            vista = 'programa';
        break;

        case 'dashboardConsultarCapacitaciones':
            vista = 'plancapacitacion';
        break;

        case 'dashboardConsultarInspecciones':
            vista = 'inspeccion';
        break;

        case 'dashboardConsultarExamenes':
            vista = 'examenmedico';
        break;

        // case 'dashboardConsultarActas':
        //     vista = 'actagrupoapoyo';
        // break;

        case 'dashboardConsultarAccidentes':
            vista = 'accidente';
        break;

        case 'dashboardConsultarGrupos':
            vista = 'actagrupoapoyo';
        break;

        default:
            vista = 'dashboard';
        break;

        
    }

    var token = document.getElementById('token').value;
    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:   'http://'+location.host+'/consultarPermisos',
        data:{vista: vista, permiso: 'modificar'},
        type:  'post',
        beforeSend: function(){
            },
        success: function(data){
            // consultamos si el usuario tiene permiso para modificar en este modulo
            if(data == 1)
            {
                window.open('http://'+location.host+'/'+vista+'/'+idTarea+'/edit');
            }   
            else
            {
                alert('Usted no tiene permiso para modificar registros en este módulo, se abrirá en modo de consulta');
                window.open('http://'+location.host+'/'+vista);
            }
            
        },
        error:    function(xhr,err){
            alert('Se ha producido un error: ' +err);
        }
    });
}