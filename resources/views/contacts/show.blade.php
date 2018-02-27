@extends("contacts.templatebis")

@section("titre")
	{{ $contact["donnee"]->prenom }} {{ $contact["donnee"]->nom }}
@endsection

@section("contenu")
	
			<div class="panel panel-default">
				<div class="panel-heading">{{ $contact["donnee"]->prenom }} {{ $contact["donnee"]->nom }}
					@if (Auth::user()->privileges != "Users")
					<form action="{{ route('contacts.destroy', $contact["donnee"]->id) }}" method="POST" style="display:inline;" id="formContactDestroy">{!! csrf_field() !!}{{ method_field('DELETE') }}
						<a class="btn btn-default pull-right" id="destroyContact"><i class="fa fa-trash"></i></a>
					</form>
					@endif
					<a href="{{ route("contacts.edit", $contact["donnee"]->id) }}" class="btn btn-default pull-right"><i class="fa fa-edit"></i></a>
				</div>
				<div class="panel-body">
					@if(!empty($contact["donnee"]->tel1))
					<div class="row">
						<div class="col-xs-1"><i class="fa fa-phone"></i></div>
						<div class="col-xs-11">{{ $contact["donnee"]->tel1 }}</div>
					</div>
					@endif
					@if(!empty($contact["donnee"]->tel2))
					<div class="row">
						<div class="col-xs-1"><i class="fa fa-phone"></i></div>
						<div class="col-xs-11">{{ $contact["donnee"]->tel2 }}</div>
					</div>
					@endif
					@if(!empty($contact["donnee"]->email))
					<div class="row">
						<div class="col-xs-1"><i class="fa fa-envelope-o"></i></div>
						<div class="col-xs-11">{{ $contact["donnee"]->email }}</div>
					</div>
					@endif

					
					@if(!empty($contact["entreprise"]))
					<br />
					<label for="structure">Structures</label>
					@foreach($contact["entreprise"] as $structure)
					<div class="row">
						<div class="col-xs-6">
							{{ $structure->nom }}
						</div>
						<div class="col-xs-6">
							{{ $structure->fonction }}
						</div>
					</div>
					@endforeach
					@endif
					<br />
					<label for="notes">Notes / Remarques </label><br />
					{!! $contact["donnee"]->notes !!}
				</div>
			</div>
		
@endsection

@section('script')
	<script>
	  jQuery(".checkStruct").each(function(){
	  	jQuery(this).change(function(e){
	  		var struct = e.target.name.substr(9);
	  		if(e.target.checked)
	  		{
	  			jQuery("#Fonctionstructure"+struct).prop('disabled', false);
	  		}
	  		else
	  		{
	  			jQuery("#Fonctionstructure"+struct).val("");
	  			jQuery("#Fonctionstructure"+struct).prop('disabled', true);
	  		}
	  	});
	  });
	  jQuery("#reset").click(function(e){
	  	jQuery(".Fonctionstructure").each(function(){
	  		jQuery(this).val("");
	  		jQuery(this).prop('disabled', true);
	  	});
	  });

	  jQuery("#destroyContact").click(function(e){
	  	if(confirm("Voulez-vous vrament supprimer ce contact ?")){
	  		jQuery("#formContactDestroy").submit();
	  	}
	  });
	  </script>
@endsection