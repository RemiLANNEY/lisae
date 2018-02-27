@extends("template")

@section("titre")
	Statistiques retards
@endsection

@section("content")
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	Retards par mois
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	        	<div id="morris-retards-byMonth"></div>
	        </div>
        </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
	        	Top des retardataires
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	        	<div id="morris-retards-byEtud"></div>
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
		var donneerbm = [
	        @foreach($retardsByMonth as $leg => $abs)
        	{
        		y: "{!! $leg !!}",
        		a: {!! $abs  !!}
        	},
        @endforeach
        	{}
        ];
		donneerbm.pop();
		
	    Morris.Bar({
	        element: 'morris-retards-byMonth',
	        data: donneerbm,
	        xkey: 'y',
	        ykeys: ['a'],
	        labels: ['Nombre de retard par mois'],
	        xLabelAngle: 35,
	        resize: false
	    });

		var donneerbe = [
			@foreach($retardsByEtud as $retards)
			{
				y:"{!! $retards['etudiant']->Prenom !!} {!! $retards['etudiant']->Nom !!}",
        		a:{!! $retards['nbRetards']  !!}
			},
			@endforeach
			{}
		]; 
		donneerbe.pop();
		
		if(donneerbe.length > 0){
		    Morris.Bar({
		        element: 'morris-retards-byEtud',
		        data: donneerbe,
		        xkey: 'y',
		        ykeys: ['a'],
		        labels: ['Top des retardataires'],
		        xLabelAngle: 35,
		        resize: false
		    }); 
	    } else {
		    //alert("test");
		    document.getElementById("morris-retards-byEtud").innerHTML = "Génial : il n'y a aucun retardataire !";
	    }
		    
	});
</script>
@endsection