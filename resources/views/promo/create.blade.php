@extends('template')

@section("titre")
	Gestion des promotions - Créer une promo
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Création d'une promo</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					
					<form action="{{ route('promo.store') }}" method="post" class="form-horizontal panel">
						 {!! csrf_field() !!}
						<div class="form-group {!! $errors->has('titre') ? 'has-error' : '' !!}">
							<input type="text" name=titre class="form-control" placeholder = 'Titre' required="required">
							{!! $errors->first('titre', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('ville') ? 'has-error' : '' !!}">
							<input type="text" name="ville" class="form-control" placeholder = 'Ville' required="required">
							{!! $errors->first('ville', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('pays') ? 'has-error' : '' !!}">
						  	<input type="text" name="pays" class="form-control" placeholder = 'Pays' required="required">
						  	{!! $errors->first('pays', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('dateDebutPromo') ? 'has-error' : '' !!}">
						  	<input type="date" name="dateDebutPromo" id="dateDebutPromo" class="form-control" placeholder = 'Date de début de la promotion - format yy-mm-dd'>
						  	{!! $errors->first('dateDebutPromo', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('dateFinPromo') ? 'has-error' : '' !!}">
						  	<input type="date" name="dateFinPromo" id="dateFinPromo" class="form-control" placeholder = 'Date de fin de la promotion - format yy-mm-dd'>
						  	{!! $errors->first('dateFinPromo', '<small class="help-block">:message</small>') !!}
						</div>
						<div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
							<label for="description">Description de la promo et commentaire</label>
						  	<textarea name="description" class="form-control" id="description" placeholder="Description de la promo et commentaire"></textarea>
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
						<input type="submit" value="Créer une Promo" class="btn btn-default pull-right">
					</form>	
				</div>
			</div>
		</div>
		<a href="{{ route('promo.index') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
	<div class="clearboth"></div>
@endsection

@section("script")
	<script>
	  $( function() {
	    $( "#dateDebutPromo" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true});
	    $( "#dateFinPromo" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true});
	    $( "#dateDebutPromo" ).datepicker( "option", "dateFormat", "yy-mm-dd");
	    $( "#dateFinPromo" ).datepicker( "option", "dateFormat", "yy-mm-dd");
	    $( "#dateDebutPromo" ).datepicker( "option", "showAnim", "fold");
	    $( "#dateFinPromo" ).datepicker( "option", "showAnim", "fold");
	    $( "#dateDebutPromo" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd", showAnim:"fold"});
	    $( "#dateFinPromo" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd", showAnim:"fold"});
	  } );
	  CKEDITOR.replace( 'description' );
	  </script>
@endsection