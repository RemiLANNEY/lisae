@extends('template')

@section("titre")
	Gestion de l'équipe - Modification
@endsection

@section('content')
    <div class="col-md-12">
    	<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Modification d'un membre</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					<form action="{{ route('user.update', $user->id) }}" method="POST" class="form-horizontal panel">
					 {!! csrf_field() !!}
					<div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
						<input type="text" name="name" class="form-control" value = '{{ $user->name }}' placeholder = 'Nom'>
					  	{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
					  	<input type="email" name="email" class="form-control" value = '{{ $user->email }}' placeholder = 'Email'>
					  	{!! $errors->first('email', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('role') ? 'has-error' : '' !!}">
					  	<input type="text" name="role" class="form-control" value = '{{ $user->role }}' placeholder = 'Rôle'>
					  	{!! $errors->first('role', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('privileges') ? 'has-error' : '' !!}">
						<select name="privileges" class="form-control">
							@if(Auth::user()->privileges == "SuperAdmin")
							<option value="SuperAdmin"@if($user->privileges == "SuperAdmin") selected @endif>SuperAdmin</option>
							@endif
							@if(Auth::user()->privileges != "Users")
							<option value="Admin"@if($user->privileges == "Admin") selected @endif>Admin</option>
							@endif
							<option value="Users"@if($user->privileges == "Users" || $user->privileges == "") selected @endif>Users</option>
						</select>
					</div>
					<div class="form-group {!! $errors->has('admin') ? 'has-error' : '' !!}">
					@if(Auth::user()->privileges == "SuperAdmin")
						<select name="admin" class="form-control">
						@foreach($users as $u)
							<option value="{{ $u->id }}"@if($u->id == $user->admin) selected @endif>Administrateur de promo : {{ $u->name }}</option>
						@endforeach
						</select>
					@else
						<input type="hidden" name="admin" value="{{ Auth::user()->id }}">
					@endif
					</div>
					
					<div class="form-group {!! $errors->has('promo_id') ? 'has-error' : '' !!}">
						<select name="promo_id" class="form-control">
							<option value=""@if(empty($promo->id)) selected @endif disabled>Promo principale </option>
						@foreach ($promos as $promo)
							<option value="{{ $promo->id }}"@if($promo->id == $user->promo_id) selected @endif>{{ $promo->titre }}</option>
						@endforeach
						</select>
					</div>
					
					<input type="submit" value="Envoyer" class="btn btn-default pull-right">
					{{ method_field('PUT') }}
					</form>
				</div>
			</div>
		</div>
		<a href="{{ route('user.index') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection