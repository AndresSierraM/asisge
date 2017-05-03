  @extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Paises</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($pais))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($pais,['route'=>['pais.destroy',$pais->idPais],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($pais,['route'=>['pais.update',$pais->idPais],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'pais.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="pais-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoPais', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoPais',null,['class'=>'form-control','placeholder'=>'Ingresa el código del país'])!!}
              {!!Form::hidden('idPais', null, array('id' => 'idPais')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!!Form::label('nombrePais', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombrePais',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del país'])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($pais))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif

	{!! Form::close() !!}
	</div>
</div>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<div id="container" style="height: 500px"></div>

<script type="text/javascript">
  $(function () {
        // Define tasks
        var tasks = [ {
            name: 'Category 1',
            intervals: [{ // From-To pairs
                from: Date.UTC(2010,5, 21),
                to: Date.UTC(2015, 5, 21),
                label: 'Category 1',
                    tooltip_data: 'Agenda 1'
            }]
        }, {
            name: 'Category 2',
            intervals: [{ // From-To pairs
                from: Date.UTC(2011,05,16),
                to: Date.UTC(2012,03,21 ),
                label: 'Category 2',
                    tooltip_data: 'Agenda 2'
            }]
        }, {
            name: 'Category 3',
            intervals: [{ // From-To pairs
                from: Date.UTC(2013,07,18 ),
                to: Date.UTC(2015,05,22),
                label: 'Category 3',
                    tooltip_data: 'Agenda 3'
            }]
        }];

        // Define milestones
        /*var milestones = [{
            name: 'Get to bed',
            time: Date.UTC(0, 0, 0, 22),
            task: 1,
            marker: {
                symbol: 'triangle',
                lineWidth: 1,
                lineColor: 'black',
                radius: 8
            }
        }];
        */
        // re-structure the tasks into line seriesvar series = [];
        var series = [];
        $.each(tasks.reverse(), function(i, task) {
            var item = {
                name: task.name,
                data: []
            };
            $.each(task.intervals, function(j, interval) {
                item.data.push({
                    x: interval.from,
                    y: i,
                    label: interval.label,
                    from: interval.from,
                    to: interval.to,
                        tooltip_data: interval.tooltip_data
                        
                }, {
                    x: interval.to,
                    y: i,
                    from: interval.from,
                    to: interval.to,
                        tooltip_data: interval.tooltip_data
                });
                
                // add a null value between intervals
                if (task.intervals[j + 1]) {
                    item.data.push(
                        [(interval.to + task.intervals[j + 1].from) / 2, null]
                    );
                }

            });

            series.push(item);
        });

        // restructure the milestones
        /*$.each(milestones, function(i, milestone) {
            var item = Highcharts.extend(milestone, {
                data: [[
                    milestone.time,
                    milestone.task
                ]],
                type: 'scatter'
            });
            series.push(item);
        });
        */

        // create the chart
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container'
            },

            title: {
                text: 'Diagrama de la Agenda'
            },

            xAxis: {
                type: 'datetime'
            },

            yAxis: {
                    min:0,
                    max:2,
                categories: ['Category 3',
                             'Category 2',
                             'Category 1'],
                tickInterval: 1,            
                tickPixelInterval: 200,
                labels: {
                    style: {
                        color: '#525151',
                        font: '12px Helvetica',
                        fontWeight: 'bold'
                    },
                   /* formatter: function() {
                        if (tasks[this.value]) {
                            return tasks[this.value].name;
                        }
                    }*/
                },
                startOnTick: false,
                endOnTick: false,
                title: {
                    text: 'Eventos'
                },
                minPadding: 0.2,
                maxPadding: 0.2,
                   fontSize:'15px'
                
            },

            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ tasks[this.y].name + '</b><br/>'+this.point.options.tooltip_data +'<br>' +
                        Highcharts.dateFormat('%m-%d-%Y', this.point.options.from)  +
                        ' - ' + Highcharts.dateFormat('%m-%d-%Y', this.point.options.to); 
                }
            },

            plotOptions: {
                line: {
                    lineWidth: 10,
                    marker: {
                        enabled: false
                    },
                    dataLabels: {
                        enabled: true,
                        align: 'left',
                        formatter: function() {
                            return this.point.options && this.point.options.label;
                        }
                    }
                }
            },

            series: series

        });      
      
      console.log(series);
      
     });
</script>
@stop