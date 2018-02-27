@extends('template')

@section("titre")
	Gestion des évaluations - update
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Mettre à jours l'évaluations <a href="{{ route('eval.destroyEval', [$candidat, $eval->id]) }}" class="pull-right"><i class="fa fa-trash"></i></a></div>
			<div class="panel-body"> 
				<div class="col-md-12">
					 <form action="{{ route('eval.update', $eval->id) }}" method="post" class="form-horizontal panel">
					 	{!! csrf_field() !!}
						<div class="form-group {!! $errors->has('eval') ? 'has-error' : '' !!}">
							<textarea name="text" class="form-control" id="text">{!! $eval->text !!}</textarea>
							<input type="hidden" name="id" value="{!! $eval->id !!}">
							<input type="hidden" name="candidat" value="{!! $candidat !!}">
							{!! $errors->first('eval', '<small class="help-block">:message</small>') !!}
						</div>
						 
						<input type="submit" value="Envoyer" class="btn btn-default pull-right">
						{{ method_field('PUT') }}
					 </form>									
				</div>
			</div>
		</div>
		<a href="{{ url()->previous() }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection

@section("script")
	<script>

	  CKEDITOR.replace( 'text' );
	  </script>
@endsection