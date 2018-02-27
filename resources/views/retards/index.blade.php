@extends("template")

@section("titre")
	Gestion des retards
@endsection

@section("content")
<div class="row">
	<div class="col-lg-5">
		<div class="panel panel-default">	
			<div class="panel-heading">Calendrier</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					<form name="form_calendrier" id="form_calendrier" method="post" action="{{ route('retards.selectCal') }}">
						{!! csrf_field() !!}
						{{ method_field('POST') }}
						
						<div class="row">
							<div class="col-md-6">
								<select name="month" id="calendar_month" class="form-control">
				                    <option value="01" @if($month==1) selected @endif>Janvier</option>
				                    <option value="02" @if($month==2) selected @endif>Fevrier</option>
				                    <option value="03" @if($month==3) selected @endif>Mars</option>
				                    <option value="04" @if($month==4) selected @endif>Avril</option>
				                    <option value="05" @if($month==5) selected @endif>Mai</option>
				                    <option value="06" @if($month==6) selected @endif>Juin</option>
				                    <option value="07" @if($month==7) selected @endif>Juillet</option>
				                    <option value="08" @if($month==8) selected @endif>Août</option>
				                    <option value="09" @if($month==9) selected @endif>Septembre</option>
				                    <option value="10" @if($month==10) selected @endif>Octobre</option>
				                    <option value="11" @if($month==11) selected @endif>Novembre</option>
				                    <option value="12" @if($month==12) selected @endif>Décembre</option>
				                </select>
		                	</div>
		                	<div class="col-md-6">
				                <select name="year" id="calendar_year" class="form-control">
				                    @for($i = 2016 ; $i < 2100 ; $i++)
				                    <option value="{{ $i }}" @if($i == $year) selected @endif>{{ $i }}</option>
				                    @endfor
				                </select>
		                	</div>
		                </div>
		                <input type="hidden" name="day" value="{{ $day }}">
		            </form>
		            <div class="row">
		            	<div class="panel-body">
	                        <table width="100%" class="table table-striped table-bordered table-hover">
	                        	<thead>
	                            	<tr>
	                                	<th>&nbsp;</th>
	                                    <th>Lun</th>
	                                    <th>Mar</th>
	                                    <th>Mer</th>
	                                    <th>Jeu</th>
	                                    <th>Ven</th>
	                                    <th>Sam</th>
	                                    <th>Dim</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            	@foreach($tablesCalendar as $lignes)
	                            	<tr>
	                            		@foreach($lignes as $key => $value)
	                                	<td @if($key==0) class="firstColonne" @endif>@if($value['link']!="") <a href="{!! $value['link'] !!}" class="{!! $value['class'] !!}">{!! $value["value"] !!}</a> @else {!! $value["value"] !!} @endif</td>
	                                	@endforeach
	                                </tr>
	                                @endforeach
	                            </tbody>
	                        </table>
                        </div>
		            </div>
				</div>
			</div>
		</div>
		
	</div>
	<div class="col-lg-7">
		<div class="panel panel-default">	
			<div class="panel-heading">&Eacute;tudiants</div>
			<div class="panel-body"> 
				<div class="col-md-12">
					 <form name="formRetardsEtudiants" method="post" action="{{ route('retards.store') }}" class="form-horizontal panel">
					 	{!! csrf_field() !!}
					 	{{ method_field('POST') }}
					 	<input type="hidden" name="date" value="{!! $now !!}">
					 	<h4 class="text-info"><small class="text-info">Date : </small>{!! $now !!}</h4><br />
					 	@foreach($candidats as $candidat)
					 	<div class="row">
					 		<div class="col-md-1"><input type="checkbox" name="etudiants[]" value="{!! $candidat->id !!}" id="etudiant_{!! $candidat->id !!}"></div>
					 		<div class="col-md-4"><label for="etudiant_{!! $candidat->id !!}" class="text-primary">{!! $candidat->Prenom !!} {!! $candidat->Nom !!}</label></div>
					 		<div class="col-md-7"><input type="text" class="form-control" name="motif_{!! $candidat->id !!}" placeholder="Motif retard"></div>
					 	</div>
					 	@endforeach
					 	<br />
					 	<input type="submit" value="Marquer comme retardataire" class="btn btn-default pull-right">
					 </form>				
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12"> 
		<a href="{{ url()->previous() }}" class="btn btn-default">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
</div>
@endsection

@section('script')
	<script>
		$("#calendar_month").change(function(){$("#form_calendrier").submit();});
		$("#calendar_year").change(function(){$("#form_calendrier").submit();});
	</script>
@endsection