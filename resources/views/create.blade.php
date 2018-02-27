@extends('template')

@section("titre")
	Gestion de l'équipe - Création
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Création d'un membre</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					<form action="{{ route('user.store') }}" method="post" class="form-horizontal panel">
					 {!! csrf_field() !!}
					<div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
						<input type="text" name="name" class="form-control" placeholder = 'Nom'>
						{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
						<input type="email" name="email" class="form-control" placeholder = 'Email'>
						{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('role') ? 'has-error' : '' !!}">
					  	<input type="text" name="role" class="form-control" placeholder = 'Rôle'>
					  	{!! $errors->first('role', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
						<input type="password" name="password" class="form-control" placeholder = 'Mot de passe'>
						{!! $errors->first('password', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group">
						<input type="password" name="password_confirmation" class="form-control" placeholder = 'Confirmation mot de passe'>
					</div>
					<div class="form-group {!! $errors->has('privileges') ? 'has-error' : '' !!}">
						<select name="privileges" class="form-control">
							@if(Auth::user()->privileges == "SuperAdmin")
							<option value="SuperAdmin">SuperAdmin</option>
							@endif
							@if(Auth::user()->privileges != "Users")
							<option value="Admin">Admin</option>
							@endif
							<option value="Users">Users</option>
						</select>
					</div>
					
					<div class="form-group {!! $errors->has('promo_id') ? 'has-error' : '' !!}">
						<select name="promo_id" class="form-control">
							<option value="" selected disabled>Promo principale </option>
						@foreach ($promos as $promo)
							<option value="{{ $promo->id }}">{{ $promo->titre }}</option>
						@endforeach
						</select>
					</div>
					
					<div class="form-group {!! $errors->has('admin') ? 'has-error' : '' !!}">
					@if(Auth::user()->privileges == "SuperAdmin")
						<select name="admin" class="form-control">
						@foreach($users as $user)
							<option value="{{ $user->id }}">{{ $user->name }} ( {{ $user->privileges }} )</option>
						@endforeach
						</select>
					@else
						<input type="hidden" name="admin" value="{{ Auth::user()->id }}">
					@endif
					</div>
					<input type="submit" value="Envoyer" class="btn btn-default pull-right">
					</form>
				</div>
			</div>
		</div>
		<a href="{{ route('user.index') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection