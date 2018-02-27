@extends("contacts.templatebis")

@section("titre")
	Gestion des contacts
@endsection

@section("contenu")
	
			<div class="panel panel-default">
				<div class="panel-heading">Nouveau contact</div>
				<div class="panel-body">
					<form name="form_contact" id="form_structure" method="post" action="{{ route('contacts.store') }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						{{ method_field('POST') }}
						
						<label for="nom">Nom *</label><input type="text" name="nom" class="form-control" required="required" id="nom"><br />
						<label for="prenom">Prenom *</label><input type="text" name="prenom" class="form-control" id="prenom"><br />
						<label for="tel1">Téléphone</label><input type="tel" name="tel1" class="form-control" id="tel1"><br />
						<label for="tel2">Téléphone</label><input type="tel" name="tel2" class="form-control" id="tel2"><br />
						<label for="email">Email </label><input type="email" name="email" class="form-control" id="email"><br />
						<label for="structure">Structures</label>
							
						@foreach($structures as $structure)
						<div class="row">
							<div class="col-xs-6">
								<input type="checkbox" name="structure{{$structure->id}}" id="structure{{$structure->id}}" class="checkStruct"> <label for="structure{{$structure->id}}"> {{ $structure->nom }}</label>
								<label for="Fonctionstructure{{$structure->id}}" class="pull-right">Fonction *</label>
							</div>
							<div class="col-xs-6">
								<input type="text" name="Fonctionstructure{{$structure->id}}" class="form-control Fonctionstructure" id="Fonctionstructure{{$structure->id}}" required="required" disabled="disabled"> 
							</div>
						</div>
						@endforeach
						<br />
						<label for="visibilite">Visible de tous</label><br />
						<input type="radio" name="visibilite" value="0" id="visbleOui"><label for="visbleOui"> Oui</label><br />
						<input type="radio" name="visibilite" value="{{ Auth::user()->id }}" id="visbleNon"><label for="visbleNon"> Non</label>
						<br />
						<label for="notes">Notes / Remarques </label><br />
						<textarea name="notes" id="notes"></textarea>
						<br />
						<div class="row">
							<div class="col-xs-6">
								<input type="submit" name="submit" id="submit" value="Enregistrer le contact" class="form-control">
							</div>
							<div class="col-xs-6">
								<input type="reset" name="reset" id="reset" value="Reset" class="form-control">
							</div>
						</div>
					</form> 
				</div>
			</div>
		
@endsection

@section('script')
	<script>

	  CKEDITOR.replace( 'notes' );
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
	  </script>
@endsection