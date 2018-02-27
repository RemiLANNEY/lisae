@extends("structure.templatebis")

@section("titre")
	{{ $structure->nom }} - Edition
@endsection

@section("contenu")

			<div class="panel panel-default">
				<div class="panel-heading">Mettre à jour la structure</div>
				<div class="panel-body">
					<form name="form_structure" id="form_structure" method="post" action="{{ route('structure.update', $structure->id) }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						{{ method_field('PUT') }}
						<div class="row">
							<div class="col-md-5">
								@if(!empty($structure->logo) && is_file('../storage/app/Logo/'.$structure->logo))
								<img src="{{ '../storage/app/Logo/'.$structure->logo }}" class="noPicture">
								@else
								<img src="images/no_picture.png" class="noPicture">
								@endif
								<input type="file" name="logo">
								<br />
								<label for="typeStructure">Type de strucure</label>
								<select name="typeStructure" id="typeStructure" class="form-control">
									<option value="Entreprise" @if($structure->typeStructure == "Entreprise") selected="selected" @endif>Entreprise</option>
									<option value="Association" @if($structure->typeStructure == "Association") selected="selected" @endif>Association</option>
									<option value="Institution" @if($structure->typeStructure == "Institution") selected="selected" @endif>Institution</option>
									<option value="Ecole" @if($structure->typeStructure == "Ecole") selected="selected" @endif>Ecole</option>
								</select>
								<br />
								<label for="visibilite">Visible de tous</label><br />
								<input type="radio" name="visibilite" value="0" @if(empty($structure->users_id)) checked="checked" @endif id="visbleOui"><label for="visbleOui"> Oui</label><br />
								<input type="radio" name="visibilite" value="{{ Auth::user()->id }}" @if(!empty($structure->users_id)) checked="checked" @endif id="visbleNon"><label for="visbleNon"> Non</label>  
							</div>
							<div class="col-md-7">
								<label for="nom">Nom de la structure *</label><input type="text" name="nom" class="form-control" required="required" id="nom" value="{{ $structure->nom }}"><br />
								<label for="adresse1">Adresse</label><input type="text" name="adresse1" class="form-control" id="adresse1" value="{{ $structure->adresse1 }}"><br />
								<label for="adresse2">Adresse</label><input type="text" name="adresse2" class="form-control" id="adresse2" value="{{ $structure->adresse2 }}"><br />
								<label for="cp">Code postal</label><input type="text" name="cp" class="form-control" id="cp" value="{{ $structure->cp }}"><br />
								<label for="ville">Ville </label><input type="text" name="ville" class="form-control" id="ville" value="{{ $structure->ville }}"><br />
								<label for="tel">Téléphone</label><input type="tel" name="tel" class="form-control" id="tel" value="{{ $structure->tel }}"><br />
								<label for="email">Email</label><input type="email" name="email" class="form-control" id="email" value="{{ $structure->email }}"><br />
								<label for="site">Site</label><input type="text" name="site" class="form-control" id="site" value="{{ $structure->site }}"><br />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<label for="notes">Notes / Remarques </label><br />
								<textarea name="notes" id="notes">{{ $structure->notes }}</textarea>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-xs-6">
								<input type="submit" name="submit" id="submit" value="Editer la structure" class="form-control">
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
	  </script>
@endsection