@extends("template")

@section("titre")
	Gestion des retards
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">	
			<div class="panel-heading">
				<div class="row">
				<div class="col-md-10">Modifier un retard</div>
				@if(Auth::user()->privileges == "SuperAdmin" || Auth::user()->privileges == "Admin")
				<form action="{{ route('retards.destroy', $retard->id ) }}" id="form_destroy"  class="col-md-2" method="post">
					{!! csrf_field() !!}
					{{ method_field('DELETE') }}
					<a class="pull-right" id="valid_form"><i class="fa fa-trash"></i></a>
				</form>
				@endif  
				</div>
			</div>
			<div class="panel-body"> 
				<form name="form_retard" id="form_retard" method="post" action="{{ route('retards.update', $retard->id) }}">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-6">
							<input type="date" name="date" id="date" class="form-control" value="{{ $retard->date }}" placeholder = 'Date du retard - format yy-mm-dd'>
						</div>
						<div class="col-md-6">
							<input type="text" name="motif" class="form-control" value="{{ $retard->motif }}"<input type="date" name="date" id="date" class="form-control" value="{{ $retard->date }}" placeholder = 'Motif du retard'>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="id_etudiant" value="{{ $retard->id_etudiant }}">
							<input type="submit" value="Mettre à jour" class="btn btn-default pull-right">
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
	$( "#date" ).datepicker({showOtherMonths: true, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd", showAnim:"fold", setDate:"{{ $retard->date }}"});
	$("#valid_form").click(function(){if(confirm("Voulez-vous vraiment supprimer ce retard ?")) {$("#form_destroy").submit();}});
</script>
@endsection