@extends('template')

@section("titre")
	Gestion des promotions - Liste
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Modification d'une promo</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					<form action="{{ route('promo.update', $promo->id ) }}" method="post" class="form-horizontal panel">
						 {!! csrf_field() !!}
						 {{ method_field('PUT') }}
						<div class="form-group {!! $errors->has('titre') ? 'has-error' : '' !!}">
							<input type="text" name=titre class="form-control" placeholder = 'Titre' value="{{ $promo->titre }}">
							{!! $errors->first('titre', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('ville') ? 'has-error' : '' !!}">
							<input type="text" name="ville" class="form-control" placeholder = 'Ville' value="{{ $promo->ville }}">
							{!! $errors->first('ville', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('pays') ? 'has-error' : '' !!}">
						  	<input type="text" name="pays" class="form-control" placeholder = 'Pays' value="{{ $promo->pays }}">
						  	{!! $errors->first('pays', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('dateDebutPromo') ? 'has-error' : '' !!}">
						  	<input type="date" name="dateDebutPromo" id="dateDebutPromo" class="form-control" value="{{ $promo->dateDebutPromo }}" placeholder = 'Date de début de la promotion - format yy-mm-dd'>
						  	{!! $errors->first('dateDebutPromo', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('dateFinPromo') ? 'has-error' : '' !!}">
						  	<input type="date" name="dateFinPromo" id="dateFinPromo" class="form-control" value="{{ $promo->dateFinPromo }}" placeholder = 'Date de fin de la promotion - format yy-mm-dd'>
						  	{!! $errors->first('dateFinPromo', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
							<label for="description">Description de la promo et commentaire</label>
						  	<textarea name="description" class="form-control" id="description" placeholder="Description de la promo et commentaire">{{ $promo->description }}</textarea>
						  	{!! $errors->first('description', '<small class="help-block">:message</small>') !!}
						</div>
						@if(Auth::user()->privileges == "SuperAdmin")
						<label for="user_id">Administrateur de la promo</label>
						<select name="user_id" id="user_id">
							@foreach (DB::table('users')->get() as $user)
								@if( $user->privileges != "Users")
							<option value="{{ $user->id }}">{{ $user->name }}</option>
								@endif
	                        @endforeach
						</select>
						@else
						<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
						@endif
						<input type="submit" value="Modifier la Promo" class="btn btn-default pull-right">
					</form>	
					@if(Auth::user()->privileges == "SuperAdmin")
					<form action="{{ route('promo.destroy', $promo->id ) }}" method="post" class="form-horizontal panel">	
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
						<input type="submit" value="Supprimer la Promo" class="btn btn-default pull-right">
					</form>
					@endif				
				</div>
			</div>
		</div>
		<a href="{{ route('promo.index') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection

@section("script")
	<script>
	$( function() {
	    $( "#dateDebutPromo" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd", showAnim:"fold", setDate:"{{ $promo->dateDebutPromo }}"});
	    $( "#dateFinPromo" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd", showAnim:"fold", setDate:"{{ $promo->dateFinPromo }}"});
	  } );
	  CKEDITOR.replace( 'description' );
	  </script>
@endsection