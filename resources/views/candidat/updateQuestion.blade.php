@extends('template')

@section("titre")
	Mise à jour de question de séléction
@endsection

@section('content')
    <div class="col-md-12">
		<br>
		<div class="panel panel-default">	
			<div class="panel-heading">Mettre à jours la question</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					 <form action="{{ route('candidat.updateQuestion') }}" method="post" class="form-horizontal panel">
					 	{!! csrf_field() !!}
						<div class="form-group {!! $errors->has('question') ? 'has-error' : '' !!}">
							<input type="text" name="question" class="form-control" value="{!! $question->question !!}">
							<input type="hidden" name="id" value="{!! $question->id !!}">
							<input type="hidden" name="candidat" value="{!! $candidat !!}">
							{!! $errors->first('question', '<small class="help-block">:message</small>') !!}
						</div>
						 
						<input type="submit" value="Envoyer" class="btn btn-default pull-right">
						{{ method_field('POST') }}
					 </form>									
				</div>
			</div>
		</div>
		<a href="{{ url()->previous() }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection