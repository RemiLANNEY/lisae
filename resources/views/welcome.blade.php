@extends("template")

@section("titre")
	Welcome to LISAE
@endsection

@section("content")
	<h4>Logiciel Informatique de Suivie et d'Administration d'Etudiants</h4>
	<br />
	<div class="row welcome">
		<div class="col-md-6">
			<strong>Promo : </strong>{{ $promo->titre }}
		</div>
		<div class="col-md-6">
			<strong>Liste : </strong>{{ session('liste') }}
		</div>
	</div>
	<div class="row welcome">
		<div class="col-md-3 accueil">
			<a href="{{ route("absences.index") }}"><i class="glyphicon glyphicon-eye-close"></i> <br />Absences</a>
		</div>
		<div class="col-md-3 accueil">
			<a href="{{ route("retards.index") }}"><i class="glyphicon glyphicon-time"></i> <br />Retards</a>
		</div>
		<div class="col-md-3 accueil">
			<a href="{{ route("promo.trombi") }}"><i class="fa fa-group"></i> <br />Trombinoscope</a>
		</div>
		<div class="col-md-3 accueil">
			<a href="{{ route("stats") }}"><i class="fa fa-dashboard"></i> <br />Statistiques</a>
		</div>
	</div>
@endsection