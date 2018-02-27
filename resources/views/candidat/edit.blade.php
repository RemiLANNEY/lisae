@extends('template')

@section("titre")
	{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}
@endsection

@section('content')
    <div class="col-md-8">
		<div class="panel panel-default">	
			<div class="panel-heading">Profil</div>
			<div class="panel-body">
				<form name="editCandidat" method="post" action="{{ route('candidat.update', $candidat->id) }}" class="form-horizontal panel">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-4 strong">Nom :</div>
						<div class="col-md-8 {!! $errors->has('Nom') ? 'has-error' : '' !!}"><input type="text" name="Prenom" value="{{ ucfirst(strtolower($candidat->Prenom)) }}"> <input type="text" name="Nom" value="{{ strtoupper($candidat->Nom) }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Sexe :</div>
						<div class="col-md-8 {!! $errors->has('Sexe') ? 'has-error' : '' !!}">
							
					 		<input type="radio" name="Sexe" value="Homme" id="sexeH" @if($candidat->Sexe == "Homme") checked @endif><label for="sexeH">Homme</label> /
					 		<input type="radio" name="Sexe" value="Femme" id="sexeF" @if($candidat->Sexe == "Femme") checked @endif><label for="sexeF">Femme</label> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Date de naissance :</div>
						<div class="col-md-8 {!! $errors->has('Date_de_naissance') ? 'has-error' : '' !!}"><input type="date" name="Date_de_naissance" value="{{ $candidat->Date_de_naissance }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Nationnalité :</div>
						<div class="col-md-8 {!! $errors->has('Nationnalite') ? 'has-error' : '' !!}"><input type="text" name="Nationalite" value="{{ $candidat->Nationalite }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Adresse :</div>
						<div class="col-md-8 {!! $errors->has('Adresse') ? 'has-error' : '' !!}"><input type="text" name="Adresse" value="{{ $candidat->Adresse }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">CP :</div>
						<div class="col-md-8 {!! $errors->has('CP') ? 'has-error' : '' !!}"><input type="text" name="CP" value="{{ $candidat->CP }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Ville :</div>
						<div class="col-md-8 {!! $errors->has('Ville') ? 'has-error' : '' !!}"><input type="text" name="Ville" value="{{ $candidat->Ville }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">QPV :</div>
						<div class="col-md-8 {!! $errors->has('QPV') ? 'has-error' : '' !!}">
						 	<input type="radio" name="QPV" value="oui" id="qpvo" @if($candidat->QPV == "oui") checked @endif><label for="qpvo">Oui</label> /
						 	<input type="radio" name="QPV" value="non" id="qpvn" @if($candidat->QPV == "non") checked @endif><label for="qpvn">Non</label> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Email :</div>
						<div class="col-md-8 {!! $errors->has('Email') ? 'has-error' : '' !!}"><input type="email" name="Email" value="{{ $candidat->Email }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Téléphone :</div>
						<div class="col-md-8 {!! $errors->has('Telephone') ? 'has-error' : '' !!}"><input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" name="Telephone" value="{{ $candidat->Telephone }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">Statut :</div>
						<div class="col-md-8 {!! $errors->has('Statut') ? 'has-error' : '' !!}"><input type="text" name="Statut" value="{{ $candidat->Statut }}"></div>
					</div>
					<div class="row">
						<div class="col-md-4 strong">N° pôle emploi :</div>
						<div class="col-md-8 {!! $errors->has('Num_pole_emploi') ? 'has-error' : '' !!}"><input type="text" name="Num_pole_emploi" value="{{ $candidat->Num_pole_emploi }}"></div>
					</div>
					<div class="row ">
						<div class="col-md-4 strong">N° secu :</div>
						<div class="col-md-8 {!! $errors->has('importFile') ? 'has-error' : '' !!}"><input type="text" name="Num_secu" value="{{ $candidat->Num_secu }}"> <input type="submit" value="Mettre à jour" class="btn btn-default pull-right"></div>
					</div>
				</form>
			</div>
		</div>
		
		
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">	
			<div class="panel-heading">Photo</div>
			<div class="panel-body">
			<?php $exist = false; ?> 
			@foreach($extImg as $ext)
				@if(file_exists(storage_path("app")."/portrait/".$candidat->id.".".$ext))
					<?php $exist = true; ?>		
				<img alt="{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ '../storage/app/portrait/'.$candidat->id.'.'.$ext }}" class="portrait">
				@endif
			@endforeach
			@if(!$exist)
				<img alt="{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{URL::asset('/images/no_visage.png')}}" class="noportrait">
				<form name="uploadPortrait" method="post" action="{{ route('candidat.portrait', $candidat->id) }}" class="form-horizontal panel" enctype = "multipart/form-data">
					{!! csrf_field() !!}
					{{ method_field('POST') }}
					<div class="form-group {!! $errors->has('"portrait"') ? 'has-error' : '' !!}">
						<input type="file" name="portrait" class="form-control" required placeholder = 'Portrait du candidat'>
						<input type="hidden" name="id" value="{{ $candidat->id }}">
						{!! $errors->first('"portrait"', '<small class="help-block">:message</small>') !!}
					</div>
					<input type="submit" value="Envoyer" class="btn btn-default pull-right">
				</form>
			@endif				
			</div>
		</div>
		
		
	</div>
	<div class="col-md-12">
		<a href="{{ url()->previous() }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection