@extends("template")

@section("titre")
	Gestion des absences
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">	
			<div class="panel-heading">
				<div class="row">
				<div class="col-md-10">Modifier une absence</div>
				@if(Auth::user()->privileges == "SuperAdmin" || Auth::user()->privileges == "Admin")
				<form action="{{ route('absences.destroy', $absence->id ) }}" id="form_destroy"  class="col-md-2" method="post">
					{!! csrf_field() !!}
					{{ method_field('DELETE') }}
					<a class="pull-right" id="valid_form"><i class="fa fa-trash"></i></a>
				</form>
				@endif  
				</div>
			</div>
			<div class="panel-body"> 
				<form name="form_absence" id="form_absence" method="post" action="{{ route('absences.update', $absence->id) }}" enctype = "multipart/form-data" >
					{!! csrf_field() !!}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-6">
							<input type="date" name="date" id="date" class="form-control" value="{{ $absence->date }}" placeholder = 'Date du absence - format yy-mm-dd'>
						</div>
						<div class="col-md-6">
							<input type="text" name="motif" class="form-control" value="{{ $absence->motif }}" placeholder = 'Motif du absence'>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 text-center">
							@if(!empty($absence->justif))
							<a href="../storage/app/Justificatifs/{{ $absence->justif }}" target="_blank"><img alt="Justificatifs" src = "../storage/app/Justificatifs/apercuImg.php?img={{ $absence->justif }}" class="portrait">
							<br />Télécharger la pièce</a> 
							@if(Auth::user()->privileges == "SuperAdmin" || Auth::user()->privileges == "Admin")
								<a class="pull-right" id="destroyJustif"> <i class="fa fa-trash"></i></a>
							@endif
							@else
							Pas de justificatif
							@endif
						</div>
						<div class="col-md-6">
							<input type="file" name="justif" placehoder="Remplacer la pièce justificatif">
						</div>
						
						<div class="col-md-6">
						<br /><br />
							<input type="hidden" name="id_etudiant" value="{{ $absence->id_etudiant }}">
							<input type="submit" value="Mettre à jour" class="btn btn-default">
						</div>
					</div>
	            </form>
			</div>
		</div>
		
	</div>
	
</div>
@endsection

@section('script')
<script>
	$( "#date" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd", showAnim:"fold", setDate:"{{ $absence->date }}"});
	$("#valid_form").click(function(){if(confirm("Voulez-vous vraiment supprimer cette absence ?")) {$("#form_destroy").submit();}});
	$("#destroyJustif").click(function(){if(confirm("Voulez-vous vraiment supprimer cette pièce justificatif ?")) {document.location.href="{{ route('absences.destroyPiece', $absence->id ) }}";}});
</script>
@endsection