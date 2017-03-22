$(document).ready(function(){

//creamos la fecha actual
		var date = new Date();
		var yyyy = date.getFullYear().toString();
		var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
		var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

		//establecemos los valores del calendario
		var options = {
			events_source: 'http://'+location.host+'/getAll',
			view: 'month',
			language: 'es-ES',
			tmpl_path: 'http://'+location.host+'/bower_components/bootstrap-calendar/tmpls/',
			tmpl_cache: false,
			day: yyyy+"-"+mm+"-"+dd,
			time_start: '10:00',
			time_end: '20:00',
			time_split: '30',
			width: '100%',
			onAfterEventsLoad: function(events) 
			{
				if(!events) 
				{
					return;
				}
				var list = $('#eventlist');
				list.html('');

				$.each(events, function(key, val) 
				{
					$(document.createElement('li'))
						.html('<a href="' + val.url + '">' + val.title + '</a>')
						.appendTo(list);
				});
			},
			onAfterViewLoad: function(view) 
			{
				$('.page-header h3').text(this.getTitle());
				$('.btn-group button').removeClass('active');
				$('button[data-calendar-view="' + view + '"]').addClass('active');
			},
			classes: {
				months: {
					general: 'label'
				}
			}
		};

		var calendar = $('#calendar').calendar(options);

		$('.btn-group button[data-calendar-nav]').each(function() 
		{
			var $this = $(this);
			$this.click(function() 
			{
				calendar.navigate($this.data('calendar-nav'));
			});
		});

		$('.btn-group button[data-calendar-view]').each(function() 
		{
			var $this = $(this);
			$this.click(function() 
			{
				calendar.view($this.data('calendar-view'));
			});
		});

		$('#first_day').change(function()
		{
			var value = $(this).val();
			value = value.length ? parseInt(value) : null;
			calendar.setOptions({first_day: value});
			calendar.view();
		});

		$('#events-in-modal').change(function()
		{
			var val = $(this).is(':checked') ? $(this).val() : null;
			calendar.setOptions(
				{
					modal: val,
					modal_type:'iframe'
				}
			);
		});
	// }(jQuery));
});

function validarFormulario(event)
{
    var route = "http://"+location.host+"/agenda";
    var token = $("#token").val();
    var dato0 = document.getElementById('idAgenda').value;
    var dato1 = document.getElementById('CategoriaAgenda_idCategoriaAgenda').value;
    var dato2 = document.getElementById('asuntoAgenda').value;
    var dato3 = document.getElementById('fechaHoraInicioAgenda').value;
    var dato4 = document.getElementById('fechaHoraFinAgenda').value;
    var dato5 = document.getElementById('Tercero_idSupervisor').value;
    var dato6 = document.getElementById('detallesAgenda').value;

    var valor = '';
    var sw = true;

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idAgenda: dato0,
                CategoriaAgenda_idCategoriaAgenda: dato1,
                asuntoAgenda: dato2,
                fechaHoraInicioAgenda: dato3,
                fechaHoraFinAgenda: dato4,
                Tercero_idSupervisor: dato5,
                detallesAgenda: dato6
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            var respuesta = JSON.stringify(msj.responseJSON); 
            alert(respuesta);
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

                (typeof msj.responseJSON.CategoriaAgenda_idCategoriaAgenda === "undefined" ? document.getElementById('CategoriaAgenda_idCategoriaAgenda').style.borderColor = '' : document.getElementById('CategoriaAgenda_idCategoriaAgenda').style.borderColor = '#a94442');

                (typeof msj.responseJSON.asuntoAgenda === "undefined" ? document.getElementById('asuntoAgenda').style.borderColor = '' : document.getElementById('asuntoAgenda').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaHoraInicioAgenda === "undefined" ? document.getElementById('fechaHoraInicioAgenda').style.borderColor = '' : document.getElementById('fechaHoraInicioAgenda').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaHoraFinAgenda === "undefined" ? document.getElementById('fechaHoraFinAgenda').style.borderColor = '' : document.getElementById('fechaHoraFinAgenda').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idSupervisor === "undefined" ? document.getElementById('Tercero_idSupervisor').style.borderColor = '' : document.getElementById('Tercero_idSupervisor').style.borderColor = '#a94442');

                (typeof msj.responseJSON.detallesAgenda === "undefined" ? document.getElementById('detallesAgenda').style.borderColor = '' : document.getElementById('detallesAgenda').style.borderColor = '#a94442');

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

function agregarEvento()
{
	$('#modalEvento').modal('show');
}

function consultarCamposAgenda(idCategoriaAgenda)
{
	var token = document.getElementById('token').value;

	$.ajax({
		headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idCategoriaAgenda' : idCategoriaAgenda},
        url:   'http://'+location.host+'/mostrarCamposAgenda/',
        type:  'post',
		success: function(respuesta)
		{
			// alert(respuesta.toSource());
			$("#claseAgenda").val(respuesta[0]['codigoCategoriaAgenda']);

        	for (var i = 0; i < respuesta.length; i++) 
        	{
        		if (respuesta[i]['nombreCampoCRM'] == 'ubicacionAgenda') 
        			$("#ubicacionAgenda").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'MovimientoCRM_idMovimientoCRM') 
        			$("#MovimientoCRM_idMovimientoCRM").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'Tercero_idResponsable') 
        			$("#Tercero_idResponsable").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'porcentajeEjecucionAgenda') 
        			$("#porcentajeEjecucionAgenda").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'estadoAgenda') 
        			$("#estadoAgenda").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'seguimientoAgenda') 
        			$("#divseguimiento").css('display','block');
        			$("#liseguimiento").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'Tercero_idAsistente') 
        			$("#divasistentes").css('display','block');
        			$("#liasistentes").css('display','block');
        	}
    	},
    	error: function(xhr,err)
    	{ 
    		$("#claseAgenda").val('');

			$("#ubicacionAgenda").css('display','none');

			$("#MovimientoCRM_idMovimientoCRM").css('display','none');

			$("#Tercero_idResponsable").css('display','none');

			$("#porcentajeEjecucionAgenda").css('display','none');

			$("#estadoAgenda").css('display','none');

			$("#liseguimiento").css('display','none');
			
			$("#liasistentes").css('display','none');
        }
	});
}

function guardarDatos(){

        var formId = '#agenda';

        var token = document.getElementById('token').value;
        $.ajax({
            async: true,
            headers: {'X-CSRF-TOKEN': token},
            url: $(formId).attr('action'),
            type: $(formId).attr('method'),
            data: $(formId).serialize(),
            dataType: 'html',
            success: function(result){
                $(formId)[0].reset();
                location.reload();
                $('#modalEvento').modal('hide');
            },
            error: function(){
                alert('No se pudo guardar el evento.');
            },
        });
}; 