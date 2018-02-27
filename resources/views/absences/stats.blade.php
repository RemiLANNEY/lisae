@extends("template")

@section("titre")
	Statistiques absences
@endsection

@section("content")
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	Absences par mois
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	        	<div id="morris-absences-byMonth"></div>
	        </div>
        </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	Top des absents
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	        	<div id="morris-absences-byEtud"></div>
	        </div>
        </div>
	</div>
	<div class="col-md-12"> 
		<a href="{{ url()->previous() }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
</div>
@endsection

@section('script')
<script>
	$(function() {
		var donneeabm = [
	        @foreach($absencesByMonth as $leg => $abs)
        	{
        		y: "{!! $leg !!}",
        		a: {!! $abs  !!}
        	},
        @endforeach
        	{}
        ];
		donneeabm.pop();
		
	    Morris.Bar({
	        element: 'morris-absences-byMonth',
	        data: donneeabm,
	        xkey: 'y',
	        ykeys: ['a'],
	        labels: ['Nombre d\'absences par mois'],
	        xLabelAngle: 35,
	        resize: false
	    });

		var donneeabe = [
			@foreach($absencesByEtud as $absences)
			{
				y:"{!! $absences['etudiant']->Prenom !!} {!! $absences['etudiant']->Nom !!}",
        		a:{!! $absences['nbAbsences']  !!}
			},
			@endforeach
			{}
		]; 
		donneeabe.pop();
			
		if(donneeabe.length > 0){
		    Morris.Bar({
		        element: 'morris-absences-byEtud',
		        data: donneeabe,
		        xkey: 'y',
		        ykeys: ['a'],
		        labels: ['Top des absents'],
		        xLabelAngle: 35,
		        resize: false
		    });
		} else {
			document.getElementById("morris-absences-byEtud").innerHTML = "Génial : il n'y a aucun absentéisme !";
		}
	});
</script>
@endsection