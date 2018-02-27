@extends("template")

@section("titre")
	Statistiques
@endsection

@section("content")
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	<i class="fa fa-pie-chart"></i> Répartition par sexe
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body flot-chart">
	        	<div id="flot-chart-pie-stats-sexe" class="flot-chart-content"></div>
	        </div>
        </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	<i class="fa fa-pie-chart"></i> Répartition QPV
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body flot-chart">
	        	<div id="flot-chart-pie-stats-qpv" class="flot-chart-content"></div>
	        </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	<i class="fa fa-pie-chart"></i> Répartition par âge (Moyenne : {!! $moyenedage !!} ans)
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body flot-chart">
	        	<div id="flot-chart-pie-stats-age" class="flot-chart-content"></div>
	        </div>
        </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	<i class="fa fa-pie-chart"></i> Répartition des âges (Moyenne : {!! $moyenedage !!} ans)
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body flot-chart">
	        	<div id="bar-stats-ages" class="flot-chart-content"></div>
	        </div>
        </div>
	</div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-pie-chart"></i> Répartition par géographie
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body flot-chart">
        <div id="flot-chart-pie-stats-geo" class="flot-chart-content"></div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
            <i class="fa fa-pie-chart"></i> Répartition par diplôme
          </div>
          <!-- /.panel-heading -->
          <div class="panel-body flot-chart">
            <div id="flot-chart-pie-stats-diplome" class="flot-chart-content"></div>
          </div>
        </div>
  </div>
</div>
@endsection

@section('script')
<script>
//flot-chart-pie-stats-sexe
jQuery(function() {

	var data = [], temp;
	
	@foreach($sexe as $key => $value)
	data.push({ 
		label: " {!! $key !!}" , 
		data: {!! $value !!} 
	});
  	@endforeach
  	var plotObj = jQuery.plot(jQuery("#flot-chart-pie-stats-sexe"), data, {
  	  series: {
  	      pie: {
  	          show: true
  	      }
  	  },
  	  grid: {
  	      hoverable: true
  	  },
  	  tooltip: true,
  	  tooltipOpts: {
  	      content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
  	      shifts: {
  	          x: 20,
  	          y: 0
  	      },
  	      defaultTheme: true
  	  }
  	});
});

//flot-chart-pie-stats-qpv
jQuery(function() {

	var data = [], temp;
	
	@foreach($qpv as $key => $value)
	data.push({ 
		label: " {!! $key !!}" , 
		data: {!! $value !!} 
	});
  	@endforeach
  	var plotObj = jQuery.plot(jQuery("#flot-chart-pie-stats-qpv"), data, {
  	  series: {
  	      pie: {
  	          show: true
  	      }
  	  },
  	  grid: {
  	      hoverable: true
  	  },
  	  tooltip: true,
  	  tooltipOpts: {
  	      content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
  	      shifts: {
  	          x: 20,
  	          y: 0
  	      },
  	      defaultTheme: true
  	  }
  	});
});

//flot-chart-pie-stats-age
jQuery(function() {

	var data = [], temp;
	
	@foreach($age as $key => $value)
	data.push({ 
		label: " {!! $key !!}" , 
		data: {!! $value !!} 
	});
  	@endforeach
  	var plotObj = jQuery.plot(jQuery("#flot-chart-pie-stats-age"), data, {
  	  series: {
  	      pie: {
  	          show: true
  	      }
  	  },
  	  grid: {
  	      hoverable: true
  	  },
  	  tooltip: true,
  	  tooltipOpts: {
  	      content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
  	      shifts: {
  	          x: 20,
  	          y: 0
  	      },
  	      defaultTheme: true
  	  }
  	});
});

jQuery(function() {
      var donneeAges = [
        @foreach($ages as $key => $age)
        {
          y: "{!! $key !!} ans",
          a: {!! $age !!}
        },
        @endforeach
      ];
      //donneeNotes.pop();
      
      Morris.Bar({
          element: 'bar-stats-ages',
          data: donneeAges,
          xkey: 'y',
          ykeys: ['a'],
          labels: ['Ages candidats'],
          xLabelAngle: 35,
          resize: true
      });
    });

    jQuery(function() {

        var data = [], temp;
        @foreach($geo as $key => $value)
          data.push({ 
            label: " {{ $key }}" , 
            data: {!! $value !!} 
          });
          @endforeach
          
          var plotObj = $.plot($("#flot-chart-pie-stats-geo"), data, {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: true
            }
          });
      });

//diplômes
jQuery(function() {

  var data = [], temp;
  
  @foreach($diplomes as $key => $value)
  data.push({ 
    label: " {!! ucfirst($key) !!}" , 
    data: {!! $value !!} 
  });
    @endforeach
    var plotObj = jQuery.plot(jQuery("#flot-chart-pie-stats-diplome"), data, {
      series: {
          pie: {
              show: true
          }
      },
      grid: {
          hoverable: true
      },
      tooltip: true,
      tooltipOpts: {
          content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
          shifts: {
              x: 20,
              y: 0
          },
          defaultTheme: true
      }
    });
});
</script>
@endsection