@extends('template')

@section("titre")
	Gestion de l'équipe
@endsection

@section('content')
    <br>
    <div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">L'équipe</h3>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Nom</th>
						<th></th>
						<th></th>
						@if (Auth::user()->privileges != "Users")
						<th></th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						@if($user->privileges != "SuperAdmin" || Auth::user()->privileges == "SuperAdmin")
						<tr>
							<td>{!! $user->id !!}</td>
							<td class="text-primary"><strong>{!! $user->name !!}</strong></td>
							<td><a href="{{ route('user.show', [$user->id]) }}" class= 'btn btn-success btn-block'>Voir</a></td>
							@if(Auth::user()->privileges != "Users" || $user->id == Auth::user()->id)
							<td><a href="{{ route('user.edit', [$user->id]) }}" class= 'btn btn-warning btn-block'>Modifier</a></td>
							@endif
							@if (Auth::user()->privileges != "Users" && Auth::user()->id != $user->id && $user->privileges != "SuperAdmin")
							<td>
								<form action="{{ route('user.destroy', [$user->id]) }}" method="POST">{!! csrf_field() !!}{{ method_field('DELETE') }}<input type="submit" class="btn btn-danger btn-block" onclick ='return confirm("Vraiment supprimer cet utilisateur ?")' value="Delete"></form>
							</td>
							@endif
						</tr>
						@endif
					@endforeach
	  			</tbody>
			</table>
		</div>
		@if (Auth::user()->privileges != "Users")
		<a href="{{ route('user.create') }}" class= 'btn btn-default btn-right'>Ajouter un utilisateur</a>
		@endif
		 {!! $links !!}
	</div>
@endsection