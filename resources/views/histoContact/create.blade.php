@extends('template')

@section("titre")
	Historiques des prises de contacts
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Nouvelle prise de contact</div>
			<div class="panel-body"> 
				<form name="addHistoContat" id="addHistoContat" method="post" action="">
					<div class="row">
						<div class="col-md-3">Contact pris avec le/la {{ $typeHisto }} :</div>
						<div class="col-md-3">
							@if(isset($contacts))
							{{ $contacts->nom }} {{ $contacts->prenom }}
							@else
							{{ $structure->nom }}
							@endif
						</div>
						<div class="col-md-2">Date : </div>
						<div class="col-md-4"><input type="text" name="date" id="datepicker" value="{{ date("d/m/Y") }}"></div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							Notes :
							<textarea name="notes" id="notes">
							</textarea>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-xs-6">
							<input type="submit" value="Créer un historique" class="form-control btn btn-default">
						</div>
						<div class="col-xs-6">
							<input type="reset" value="Reset" class="form-control btn btn-default">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clearboth"></div>
@endsection

@section("script")
	<script>
		CKEDITOR.replace( 'notes' );
		$( function() {
			$( "#datepicker" ).datepicker({
		      changeMonth: true,
		      changeYear: true
		    });
		    
	    	$( "#datepicker" ).datepicker( "option", "showAnim", "slide" );
	    	$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy" );
		  } );
	</script>
@endsection