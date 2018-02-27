@extends("template")

@section("titre")
	Aperçu position candidat
@endsection

@section("content")
	<!-- <div id="position_candidat_selection" class="col-xs-12 selections">
		<img src="../storage/app/public/Selection.png" alt="Fond position candidat" id="fond_position_candidat">
		<div id="compteur"></div>
	</div> -->
	<div class="row">
		<div class="col-md-8">
			<table id="selection" class="display">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nom</th>
						<th>Email</th>
						<th>Pré-séléction</th>
						<th>Séléction</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Nom</th>
						<th>Email</th>
						<th>Pré-séléction</th>
						<th>Séléction</th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($return as $candidat)
					<tr>
						<td><a href="{{ route('candidat.show', $candidat['id']) }}">{{ $candidat['id'] }}</a></td>
						<td><a href="{{ route('candidat.show', $candidat['id']) }}" class="black"><strong>{{ $candidat['Nom'] }}</strong></a></td>
						<td><a href="mailto:{{ $candidat['email'] }}" class="black">{{ $candidat['email'] }}</a></td>
						<td>{{ round($candidat['preselection'],2) }}</td>
						<td>{{ round($candidat['selection'],2) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
		        	<i class="fa fa-pie-chart"></i> Répartition par sexe
		        </div>
		        <!-- /.panel-heading -->
		        <div class="panel-body flot-chart">
		        	<div id="flot-chart-pie-stats-sexe" class="flot-chart-content"></div>
		        </div>
	        </div>
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
	</div>
	
@endsection

@section('script')
	<script>
		jQuery(document).ready(function(){
		    var table = jQuery('#selection').DataTable({
		      "paging":   true,
		      "info":     false,
		      "order": [[ 3, 'desc' ], [ 1, 'asc' ]]
		     });
		    //table.page.len( 60 ).draw();
		    jQuery(function() {

				var data = [], temp;
				<?php $nbH=0; $nbF=0; $nbA=0; 
					foreach($return as $cand){
						switch($cand['sexe']){
							case "Homme":
								$nbH++;
								break;
							case "Femme":
								$nbF++;
								break;
							default:
								$nbA++;
								break;
						}
					}
				?>
				@foreach($return as $candidat)
					
			  	@endforeach
			  	data.push({ 
					label: " Homme" , 
					data: {!! $nbH !!} 
				});
				data.push({ 
					label: " Femme" , 
					data: {!! $nbF !!} 
				});
				data.push({ 
					label: " Autre" , 
					data: {!! $nbA !!} 
				});
			  	var plotObj = $.plot($("#flot-chart-pie-stats-sexe"), data, {
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

				var data = [], temp;
				<?php
					$villesCand = array("Cannes Pays de Lerins" => 0, "Autres" => 0); 
					$villesAgglo = array("06250", "06400", "06150", "06110", "06210", "06590");
					foreach($return as $cand){
						if(in_array($cand['ville'], $villesAgglo)){
							$villesCand["Cannes Pays de Lerins"] += 1;
						} else {
							$villesCand["Autres"] += 1;
						}
					}
				?>
				@foreach($villesCand as $key => $value)
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
		  });
	</script>
@endsection