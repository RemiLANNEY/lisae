@extends("structure.templatebis")

@section("titre")
	{{ $structure->nom }}
@endsection

@section("contenu")
	
			<div class="panel panel-default">
				<div class="panel-heading">{{ $structure->nom }} <small>({{ $structure->typeStructure }})</small><a href="{{ route("structure.edit", $structure->id) }}" class="btn btn-default pull-right"><i class="fa fa-edit"></i></a></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-5">
							@if(!empty($structure->logo) && is_file('../storage/app/Logo/'.$structure->logo))
							<img src="{{ '../storage/app/Logo/'.$structure->logo }}" class="noPicture">
							@else
							<img src="images/no_picture.png" class="noPicture">
							@endif
						</div>
						<div class="col-md-7">
							@if(!empty($structure->adresse1))
							<div class="row">
								<div class="col-xs-2"><i class="fa fa-address-card-o"></i></div>
								<div class="col-xs-10">{{ $structure->adresse1 }}</div>
							</div>
							@endif
							@if(!empty($structure->adresse2))
							<div class="row">
								<div class="col-xs-2"></div>
								<div class="col-xs-10">{{ $structure->adresse2 }}</div>
							</div>
							@endif
							@if(!empty($structure->cp))
							<div class="row">
								<div class="col-xs-2"></div>
								<div class="col-xs-10">{{ $structure->cp }}</div>
							</div>
							@endif
							@if(!empty($structure->ville))
							<div class="row">
								<div class="col-xs-2"></div>
								<div class="col-xs-10">{{ $structure->ville }}</div>
							</div>
							@endif
							@if(!empty($structure->tel))
							<div class="row">
								<div class="col-xs-2"><i class="fa fa-phone"></i></div>
								<div class="col-xs-10">{{ $structure->tel }}</div>
							</div>
							@endif
							@if(!empty($structure->email))
							<div class="row">
								<div class="col-xs-2"><i class="fa fa-envelope-o"></i></div>
								<div class="col-xs-10">{{ $structure->email }}</div>
							</div>
							@endif
							@if(!empty($structure->site))
							<div class="row">
								<div class="col-xs-2"><i class="fa fa-globe"></i></div>
								<div class="col-xs-10"><a href="{{ $structure->site }}" target="_blank">{{ $structure->site }}</a></div>
							</div>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							{!! $structure->notes !!}
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Historiques des prises de contacts<a href="{{ route("HistoContact.Add", $structure->id) }}" class="btn btn-default pull-right"><i class="fa fa-calendar-plus-o"></i></a></div>
				<div class="panel-body">
					@if(empty($histo))
					Aucun historique à afficher !
					@else
					@endif
				</div>
			</div>
			@if(!empty($contacts))
			<div class="panel panel-default">
				<div class="panel-heading">Contacts</div>
				<div class="panel-body">
					<div class="row"> 

					@foreach($contacts as $contact)
						@if($compteur == 2)
					</div>
					<div class="row"> 
						<?php $compteur = 0; ?>
						@endif
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">{{ $contact->nom }} {{ $contact->prenom }}</div>
								<div class="panel-body">
									@if(!empty($contact->fonction))
									<div class="row">
										<div class="col-xs-12">{{ $contact->fonction }}</div>
									</div>
									<br />
									@endif
									@if(!empty($contact->tel1))
									<div class="row">
										<div class="col-xs-2"><i class="fa fa-phone"></i></div>
										<div class="col-xs-10 tel">{{ $contact->tel1 }}</div>
									</div>
									@endif
									@if(!empty($contact->tel2))
									<div class="row">
										<div class="col-xs-2"><i class="fa fa-phone"></i></div>
										<div class="col-xs-10 tel">{{ $contact->tel2 }}</div>
									</div>
									@endif
									@if(!empty($contact->email))
									<div class="row">
										<div class="col-xs-2"><i class="fa fa-envelope-o"></i></div>
										<div class="col-xs-10"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
									</div>
									@endif
								</div>
							</div>
						</div> 
						<?php $compteur++; ?>
					@endforeach	
					</div>
				</div>
			</div>
			@endif

@endsection

@section('script')
	<script>

	  (function(){
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){
				jQuery(".tel").each(function(){
					var temp = jQuery(this).html();
					jQuery(this).html('<a href="tel:'+temp+'">'+temp+'</a>');
				});

				// var tel1 = jQuery("#tel1").html();
		  //   	jQuery("#tel1").html('<a href="tel:'+tel1+'">'+tel1+'</a>');
		  //   	var tel2 = jQuery("#tel2").html();
		  //   	jQuery("#tel2").html('<a href="tel:'+tel2+'">'+tel2+'</a>');
		  	}
		})();
	  </script>
@endsection