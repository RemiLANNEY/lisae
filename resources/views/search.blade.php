@extends('template')

@section("titre")
	Resultat de la recherche ({{ $nb }}) : {{ $search }}
@endsection

@section('content')
    @foreach($result as $candidat)

    <div class="row">
    	<div class="col-xs-12">
    		<div class="panel panel-default">	
				<!-- <div class="panel-heading">Photo</div> -->
				<div class="panel-body">
					<div class="row">
				    	<div class="col-md-2">
				    		<a href="{{ route('candidat.show', $candidat->id) }}">
				    		<?php $exist = false; ?> 
				    		@foreach($extImg as $ext)
								@if(file_exists(storage_path("app")."/portrait/".$candidat->id.".".$ext))
									<?php $exist = true; ?>		
								<img alt="{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ '../storage/app/portrait/'.$candidat->id.'.'.$ext }}" class="portrait">
								@endif
							@endforeach
							@if(!$exist)
								<img alt="{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{URL::asset('/images/no_visage.png')}}" class="noportrait">
							@endif
							</a>
				    	</div>
				    	<div class="col-md-10">
				    		<a href="{{ route('candidat.show', $candidat->id) }}"><strong>{{ $candidat->Nom }} {{ $candidat->Prenom }}</strong></a>
				    		<div class="row">
				    			<div class="col-md-3">{{ $candidat->Adresse }} <br /> {{ $candidat->CP }} {{ $candidat->Ville }}</div>
				    			<div class="col-md-3">Email : <br /><a href="mailto:{{ $candidat->Email }}"> {{ $candidat->Email }}</a></div>
				    			<div class="col-md-3">Téléphone : <br />{{ $candidat->Telephone }}</div>
				    			<div class="col-md-3">
				    				N° pôle emploi : {{ $candidat->Num_pole_emploi }}<br />
				    				N° Secu : {{ $candidat->Num_secu }}<br />
				    			</div>
				    		</div>
				    	</div>
				    </div>
				</div>
			</div>
    	</div>
    </div>
  	
    
    @endforeach
@endsection

