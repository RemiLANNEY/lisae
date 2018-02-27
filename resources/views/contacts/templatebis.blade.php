@extends("template")

@section("titre")
	@yield("titre")
@endsection

@section("content")
	<div class="row">
		<div class="col-md-3">
			@if(sizeof($contacts)==0)
			Aucun contact n'est enregistrée
			@endif
			<ul class="nopuce">
			@foreach ($contacts as $cont)
				<li><a href="{{ route("contacts.show", $cont['donnee']->id) }}">{{ $cont['donnee']->nom }} {{ $cont['donnee']->prenom }} @if(!empty($cont['entreprise'])) ({{ implode(", ", $cont['entreprise']) }}) @endif</a></li>
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