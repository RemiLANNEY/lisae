@extends('template')

@section("titre")
	Gestion des promotions - Trombinoscope
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">{!! $promo->titre !!}</div>
			<div class="panel-body">
				@if(sizeof($trombi) != 0)
					<?php $nb = 0; ?> 
					@foreach($trombi as $etudiant)
						@if($nb == 0)
						<div class="row">
						@endif
							<div class="col-md-2 text-center">
								<a href="{{ route('candidat.show', $etudiant['id']) }}"><img alt="{!! $etudiant['name'] !!}" src="{!! $etudiant['src'] !!}" class="portrait"></a> 
								<p class="text-primary marginTop10">{!! $etudiant['name'] !!}</p>
							</div>
							<?php $nb++; ?>
						@if($nb == 6)
						<?php $nb = 0; ?>
						</div>
						@endif	
					@endforeach
				@else
					<p class="text-warning">Il n'y a personne dans la liste selectionnée</p>
				@endif					
			</div>
		</div>
		<a href="{{ route('promo.index') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection