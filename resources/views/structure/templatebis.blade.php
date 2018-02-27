@extends("template")

@section("titre")
	@yield("titre")
@endsection

@section("content")
	<div class="row">
		<div class="col-md-3">
			@if(sizeof($structures)==0)
			Aucune structure n'est enregistrée
			@endif
			<ul class="nopuce">
			@foreach ($structures as $struct)
				<li><a href="{{ route("structure.show", $struct->id)}}">@if(!empty($struct->logo) && is_file('../storage/app/Logo/'.$struct->logo))
							<img src="{{ '../storage/app/Logo/'.$struct->logo }}" class="listeStructure">
							@else
							<img src="images/no_picture.png" class="listeStructure">
							@endif 
							{{ $struct->nom }}</a></li>
			@endforeach
			</ul>
		</div>
		<div class="col-md-9">
			@yield("contenu")
		</div>
	</div>
@endsection

@section('script')
	@yield("script")
@endsection