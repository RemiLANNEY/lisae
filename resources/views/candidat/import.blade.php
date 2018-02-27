@extends('template')

@section("titre")
	Importer des candidats - Ajouter des candidats
@endsection

@section('content')
    <div class="col-md-12">
		<div class="panel panel-default">	
			<div class="panel-heading">Importation de candidats</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					 <form action="{{ route('candidat.insert') }}" method="post" class="form-horizontal panel" enctype = "multipart/form-data" >
					 {!! csrf_field() !!}
						 <div class="form-group {!! $errors->has('importFile') ? 'has-error' : '' !!}">
							<input type="file" name="importFile" placeholder = 'Votre fichier CSV'>
							{!! $errors->first('importFile', '<small class="help-block">:message</small>') !!}
							<br />
							<select name="promo_id" class="form-control" required>
								<option selected value="0">Séléctionner la promo</option>
								<option disabled >----</option>
								@foreach (DB::table('promos')->get() as $promo)
		                    		@if(Auth::user()->privileges == "SuperAdmin" || $promo->user_id == Auth::user()->id ) 
			                    <option value="{{ $promo->id }}">{{ $promo->titre }}</option>
		                        	@endif
		                        @endforeach
							</select>
						 </div>
						 <input type="submit" value="Envoyer" class="btn btn-default pull-right">
						{{ method_field('POST') }}
					 </form>									
				</div>
			</div>
		</div>
		<a href="{{ url()->previous() }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection