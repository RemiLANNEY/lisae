@extends('template')

@section("titre")
	Gestion de l'équipe - Voir
@endsection

@section('content')
    <div class="col-md-12">
    	<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Fiche de membre</div>
			<div class="panel-body"> 
				<p><strong>Nom</strong> : {{ $user->name }}</p>
				<p><strong>Email</strong> : {{ $user->email }}</p>
				<p><strong>Rôle</strong> : {{ $user->role }}</p>
				<p><strong>Privileges</strong> : {{ $user->privileges }}</p>
			</div>
		</div>				
		<a href="{{ route('user.index') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection

