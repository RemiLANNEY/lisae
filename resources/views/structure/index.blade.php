@extends("structure.templatebis")

@section("titre")
	Gestion des structures partenaires
@endsection

@section("contenu")
	
			<div class="panel panel-default">
				<div class="panel-heading">Nouvelle structure</div>
				<div class="panel-body">
					<form name="form_structure" id="form_structure" method="post" action="{{ route('structure.store') }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						{{ method_field('POST') }}
						<div class="row">
							<div class="col-md-5">
								<img src="images/no_picture.png" class="noPicture">
								<input type="file" name="logo">
								<br />
								<label for="typeStructure">Type de strucure</label>
								<select name="typeStructure" id="typeStructure" class="form-control">
									<option value="Entreprise" selected="selected">Entreprise</option>
									<option value="Association">Association</option>
									<option value="Institution">Institution</option>
									<option value="Ecole">Ecole</option>
								</select>
								<br />
								<label for="visibilite">Visible de tous</label><br />
								<input type="radio" name="visibilite" value="0" id="visbleOui"><label for="visbleOui"> Oui</label><br />
								<input type="radio" name="visibilite" value="{{ Auth::user()->id }}" id="visbleNon"><label for="visbleNon"> Non</label>  
							</div>
							<div class="col-md-7">
								<label for="nom">Nom de la structure *</label><input type="text" name="nom" class="form-control" required="required" id="nom"><br />
								<label for="adresse1">Adresse</label><input type="text" name="adresse1" class="form-control" id="adresse1"><br />
								<label for="adresse2">Adresse</label><input type="text" name="adresse2" class="form-control" id="adresse2"><br />
								<label for="cp">Code postal</label><input type="text" name="cp" class="form-control" id="cp"><br />
								<label for="ville">Ville </label><input type="text" name="ville" class="form-control" id="ville"><br />
								<label for="tel">Téléphone</label><input type="tel" name="tel" class="form-control" id="tel"><br />
								<label for="email">Email</label><input type="email" name="email" class="form-control" id="email"><br />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<label for="notes">Notes / Remarques </label><br />
								<textarea name="notes" id="notes"></textarea>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-xs-6">
								<input type="submit" name="submit" id="submit" value="Enregistrer la structure" class="form-control">
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