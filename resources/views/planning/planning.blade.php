@extends('template')

@section("titre")
	Planning
@endsection

@section('content')
	<div class="panel panel-default">	
		<div class="panel-heading">Agenda de la semaine 
			<form name="selectSemaine"  id="form_selectSemaine" method="POST" action="{{ route('planning.selectCal') }}" class="inline">
				{!! csrf_field() !!}
				{{ method_field('POST') }}
				<select name="numSemaine" class="inline" id="numSemaine">
					@for($i=1;$i<=52;$i++)
					<option value="{{ $i }}"@if($numSemaine == $i) selected="selected" @endif>{{ $i }}</option>
					@endfor
				</select>
			</form>
		</div>
		<div class="panel-body"> 
			<table width="100%" class="cell-border display compact" id="agenda">
				<thead>
					<tr>
                    	<th><a href="{{ route("planning.otherSemaine", (date("W", strtotime("last week ".$numSemaine." week")))) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>
</a></th>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mer</th>
                        <th>Jeu</th>
                        <th>Ven</th>
                        <th>Sam</th>
                        <th>Dim</th>
                        <th><a href="{{ route("planning.otherSemaine", (date("W", strtotime("next week ".$numSemaine." week")))) }}"><i class="fa fa-chevron-right" aria-hidden="true"></i>
</a></th>
                    </tr>
				</thead>
				<tfoot>
					<tr>
                    	<th><a href="{{ route("planning.otherSemaine", (date("W", strtotime("last week ".$numSemaine." week")))) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>
</a></th>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mer</th>
                        <th>Jeu</th>
                        <th>Ven</th>
                        <th>Sam</th>
                        <th>Dim</th>
                        <th><a href="{{ route("planning.otherSemaine", (date("W", strtotime("next week ".$numSemaine." week")))) }}"><i class="fa fa-chevron-right" aria-hidden="true"></i>
</a></th>
                    </tr>
				</tfoot>
				<tbody>
                	@foreach($agenda as $key => $value)
            		<tr>
            			<th>{{ $key }}</th>
            				@foreach($value as $day)
            			<td>{{ $day }}</td>
            				@endforeach
            			<th>{{ $key }}</th>
                	</tr>
                	@endforeach
                </tbody>
            </table>
		</div>
	</div>
@endsection

@section('script')
	<script>
		  jQuery(document).ready(function(){
		  	jQuery("#calendar_month").change(function(){jQuery("#form_calendrier").submit();});
			jQuery("#calendar_year").change(function(){jQuery("#form_calendrier").submit();});
		    jQuery('#agenda').DataTable({
		      "paging":   false,
		      "ordering": false,
		      "info":     false,
		      "filter":   false 
		     });
		    jQuery("#numSemaine").change(function(){jQuery("#form_selectSemaine").submit();});
		  });
	</script>
@endsection