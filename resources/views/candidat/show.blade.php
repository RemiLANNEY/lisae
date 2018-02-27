@extends('template')

@section("titre")
	{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }} 
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
		<div class="panel panel-default">	
			<div class="panel-heading">Profil</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 strong">Nom :</div>
					<div class="col-md-8">{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }} <a href="{{ route('candidat.edit', $candidat->id) }}" class="btn btn-default pull-right"><i class="fa fa-edit"></i></a></div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Sexe :</div>
					<div class="col-md-8">
					@if(empty($candidat->Sexe) || ($candidat->Sexe != "Homme" && $candidat->Sexe != "Femme"))
					 	<form name="candidatSexe" method="post" action="{{ route('candidat.update', $candidat->id) }}" class="form-horizontal panel">
					 	 {!! csrf_field() !!}
					 	 {{ method_field('PUT') }}
					 		<input type="radio" name="Sexe" value="H" id="sexeH" required><label for="sexeH">Homme</label> /
					 		<input type="radio" name="Sexe" value="F" id="sexeF" required><label for="sexeF">Femme</label> 
					 		&nbsp;<input type="submit" value="Mettre à jour" class="btn btn-default pull-right">
					 	</form>
					 @else
					 	@if($candidat->Sexe == "Homme") 
					 		<i class="fa  fa-male"></i>
					 	@elseif($candidat->Sexe == "Femme")
					 		<i class="fa  fa-female"></i>
					 	@endif
					 @endif</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Date de naissance :</div>
					<div class="col-md-8">{{ $candidat->Date_de_naissance }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Nationalité :</div>
					<div class="col-md-8">{{ $candidat->Nationalite }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Adresse :</div>
					<div class="col-md-8">{{ $candidat->Adresse }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">CP :</div>
					<div class="col-md-8">{{ $candidat->CP }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Ville :</div>
					<div class="col-md-8">{{ $candidat->Ville }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">QPV :</div>
					<div class="col-md-8">@if(empty($candidat->QPV))
					 	<form name="candidatQPV" method="post" action="{{ route('candidat.update', $candidat->id) }}" class="form-horizontal panel">
					 	 {!! csrf_field() !!}
					 	 {{ method_field('PUT') }}
					 		<input type="radio" name="QPV" value="oui" id="qpvo" required><label for="qpvo">Oui</label> /
					 		<input type="radio" name="QPV" value="non" id="qpvn" required><label for="qpvn">Non</label> 
					 		&nbsp;<input type="submit" value="Mettre à jour" class="btn btn-default pull-right">
					 	</form>
					 @else
					 	{{ $candidat->QPV }}
					 @endif</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Email :</div>
					<div class="col-md-8">{{ $candidat->Email }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Téléphone :</div>
					<div class="col-md-8">{{ $candidat->Telephone }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">Statut :</div>
					<div class="col-md-8">{{ $candidat->Statut }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">N° pôle emploi :</div>
					<div class="col-md-8">{{ $candidat->Num_pole_emploi }}</div>
				</div>
				<div class="row">
					<div class="col-md-4 strong">N° secu :</div>
					<div class="col-md-8">{{ $candidat->Num_secu }}</div>
				</div>
			</div>
		</div>
		
		
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">	
			<div class="panel-heading">Photo</div>
			<div class="panel-body">
			<?php $exist = false; ?> 
			@foreach($extImg as $ext)
				@if(file_exists(storage_path("app")."/portrait/".$candidat->id.".".$ext))
					<?php $exist = true; ?>		
				<img alt="{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ '../storage/app/portrait/'.$candidat->id.'.'.$ext }}" class="portrait">
				@endif
			@endforeach
			@if(!$exist)
				<img alt="{{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{URL::asset('/images/no_visage.png')}}" class="noportrait">
				<form name="uploadPortrait" method="post" action="{{ route('candidat.portrait', $candidat->id) }}" class="form-horizontal panel" enctype = "multipart/form-data">
					{!! csrf_field() !!}
					{{ method_field('POST') }}
					<div class="form-group {!! $errors->has('"portrait"') ? 'has-error' : '' !!}">
						<input type="file" name="portrait" placeholder = 'Portrait du candidat'>
						<input type="hidden" name="id" value="{{ $candidat->id }}">
						{!! $errors->first('"portrait"', '<small class="help-block">:message</small>') !!}
					</div>
					<input type="submit" value="Envoyer" class="btn btn-default pull-right">
				</form>
			@endif				
			</div>
		</div>
		
		
	</div>
	<div class="col-md-12">
		<div class="panel panel-default">	
			<div class="panel-body">
				<!-- Nav tabs -->
                <ul class="nav nav-tabs">
                	<li class="active"><a href="#abs" data-toggle="tab">Absences / Retards</a>
                    </li>
                    <li><a href="#eval" data-toggle="tab">Evaluation</a>
                    </li>
                    <li><a href="#repon" data-toggle="tab">Reponses</a>
                    </li>
                    <li><a href="#selec" data-toggle="tab">Selection</a>
                    </li>
                    <li><a href="#administratif" data-toggle="tab">Administratif</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                	<div class="tab-pane fade in active" id="abs">
                    	<h4>Absences / Retards</h4>
                        <div class="row">
                        	<div class="col-md-6">
                        		<div class="panel panel-default">
									<div class="panel-heading">{!! ucfirst($calendrier['month']) !!} {!! $calendrier['year'] !!}</div>					
									<div class="panel-body">
		                        		<table width="100%" class="table table-striped table-bordered table-hover">
				                        	<thead>
				                            	<tr>
				                                	<th width="9%">&nbsp;</th>
				                                    <th width="13%">Lun</th>
				                                    <th width="13%">Mar</th>
				                                    <th width="13%">Mer</th>
				                                    <th width="13%">Jeu</th>
				                                    <th width="13%">Ven</th>
				                                    <th width="13%">Sam</th>
				                                    <th width="13%">Dim</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            	@foreach($calendrier['content'] as $lignes)
				                            	<tr>
				                            		@foreach($lignes as $key => $value)
				                                	<td class="@if($key==0) firstColonne @endif"><p class=" {!! $value["class"] !!}">{!! $value["value"] !!}</p></td>
				                                	@endforeach
				                                </tr>
				                                @endforeach
				                            </tbody>
				                        </table>
				                    </div>
				            	</div>    
                        	</div>
                        	<div class="col-md-6">
                        		<div class="panel panel-default">
									<div class="panel-heading">Retards</div>					
									<div class="panel-body">
										@if(sizeof($retard)!=0)
											@if(sizeof($retardsSem)>=1 && sizeof($retardsSem)<3)
										<p class="text-warning">
											@elseif(sizeof($retardsSem)>=3)
										<p class="text-danger">
											@else
										<p class="text-info">
											@endif
											{{ sizeof($retard) }} retard(s) à signalé(s) dont {{ sizeof($retardsSem) }} durant les 7 derniers jours
										</p>
											@foreach($retards as $ret)
										<div class="row">
											<div class="col-md-6 {{ $ret['class'] }}">{!! $ret['date'] !!}</div>
											@if(Auth::user()->privileges == "SuperAdmin" || Auth::user()->privileges == "Admin" )
											<div class="col-md-5 {{ $ret['class'] }}">{!! $ret['motif'] !!}</div>
											<div class="col-md-1 {{ $ret['class'] }}"><a href="{{ route("retards.edit", $ret['id']) }}"><i class="fa fa-edit {{ $ret['class'] }}"></i></a></div>
											@else
											<div class="col-md-6 {{ $ret['class'] }}">{!! $ret['motif'] !!}</div>
											@endif
										</div>
											@endforeach
										@else
										Aucun retard à signalé.
										@endif
									</div>
								</div>
                        	</div>
                        	<div class="col-md-6">
                        		<div class="panel panel-default">
									<div class="panel-heading">Absences</div>					
									<div class="panel-body">										
										@if(sizeof($absence)!=0)
											@if(sizeof($absencesSem)>=1 && sizeof($absencesSem)<3)
										<p class="text-warning">
											@elseif(sizeof($absencesSem)>=3)
										<p class="text-danger">
											@else
										<p class="text-info">
											@endif
											{{ sizeof($absence) }} absence(s) à signalée(s) dont {{ sizeof($absencesSem) }} durant les 30 derniers jours
										</p>
											@foreach($absences as $abs)
										<div class="row">
											<div class="col-md-6 {{ $abs['class'] }}">{!! $abs['date'] !!}</div>
											<div class="col-md-4 {{ $abs['class'] }}">{!! $abs['motif'] !!}</div>
											<div class="col-md-2 {{ $abs['class'] }} text-right">
											@if(!empty($abs['justif']))
											<a href="{{ "../storage/app/Justificatifs/".$abs['justif'] }}" target="_blank"><i class="fa fa-eye {{ $abs['class'] }}"></i></a>
											@endif
											@if(Auth::user()->privileges == "SuperAdmin" || Auth::user()->privileges == "Admin" )
											<a href="{{ route("absences.edit", $abs['id']) }}"><i class="fa fa-edit {{ $abs['class'] }}"></i></a>
											@endif
											</div>
										</div>
											@endforeach
										@else
										Aucune absence à signalée.
										@endif
									</div>
								</div>
                        	</div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="eval">
                    	<br />
                        <div class="panel panel-default">
							<div class="panel-heading">Créer une évaluation</div>					
							<div class="panel-body">
								<form name="form_eval" method="post" action="{{ route('eval.store', $candidat->id) }}" class="form-horizontal panel">
									{!! csrf_field() !!}
					 	 			{{ method_field('POST') }}
					 	 			<label for="final">&Eacute;valuation </label>
					 	 			<select name="final">
					 	 				<option value="1">finale</option>
					 	 				<option value="0" selected>intérmédiaire</option>
					 	 			</select>
					 	 			<textarea name="text" class="form-control" id="newEval" placeholder="New Eval"></textarea>
						  			{!! $errors->first('text', '<small class="help-block">:message</small>') !!}
						  			<input type="hidden" name="id_etudiant" value="{{ $candidat->id }}" />
						  			<input type="submit" value="Save" class="btn btn-default pull-right">
								</form>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">&Eacute;valuations précédentes</div>					
							<div class="panel-body">
								@if(sizeof($evals)==0)
								Aucune évaluation enregistrée
								@else
									@foreach($evals as $eval)
								<div class="panel panel-default">
									<div class="panel-heading">{!! ucfirst($eval->updated_at) !!} <a href="{{ route('eval.formEditEval', [$candidat->id, $eval->id]) }}" class="pull-right"><i class="fa fa-edit"></i></a></div>					
									<div class="panel-body">
										{!! $eval->text !!}
									</div>
								</div>
									@endforeach
								@endif
							</div>
						</div>
                    </div>

                    <div class="tab-pane fade" id="repon">
                    	<br />
                        @foreach($reponsesSelection as $reponses)
                        <div class="panel panel-default">
							<div class="panel-heading">{{ $reponses->question }} @if(Auth::user()->privileges == "SuperAdmin" || Auth::user()->privileges == "Admin")<a href="{{ route('candidat.formUpdateQuestion', [$candidat->id, $reponses->id_question]) }}" class="pull-right"><i class="fa fa-edit"></i></a>@endif</div>					
							<div class="panel-body">
								<small>
								@if(strtolower(substr($reponses->reponse, 0, 4)) == "http")
									<a href="{{ $reponses->reponse }}" target="_blank">{{ $reponses->reponse }}</a>
								@else
									{{ $reponses->reponse }}
								@endif
								</small>
							</div>
						</div>
						@endforeach
                    </div>

                    
					<!-- Selection des candidats -->
                    <div class="tab-pane fade" id="selec">
                    	<br />
                    	<div class="panel panel-default">
							<div class="panel-heading">Choix listes</div>					
							<div class="panel-body">
								<form name="form_notes" method="post" action="{{ route('candidat.update', $candidat->id) }}" class="form-horizontal panel">
									{!! csrf_field() !!}
					 	 			{{ method_field('put') }}
					 	 			<label for="liste">Liste </label>
					 	 			<select name="liste">
					 	 				<option value="candidat" @if($candidat->liste=="candidat") selected @endif>Candidat</option>
					 	 				<option value="principale" @if($candidat->liste=="principale") selected @endif>Principale</option>
					 	 				<option value="attente" @if($candidat->liste=="attente") selected @endif>Attente</option>
					 	 				<option value="negative" @if($candidat->liste=="negative") selected @endif>Negative</option>
					 	 			</select>
					 	 			<input type="submit" value="Enregistrer" class="btn btn-default pull-right">
								</form>
							</div>
						</div>
						<form name="form_select" id="form_notes_select" method="post" action="{{ route('candidat.Selec', $candidat->id) }}" class="form-horizontal panel">
							{!! csrf_field() !!}
							{{ method_field('POST') }}
							<div class="row">
								<div class="col-md-8">
									<div class="panel panel-default">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-8">Pôle Administratif</div>
												<div class="col-md-2">Pré-séléction</div>
												<div class="col-md-2">Entretiens</div>
											</div>
										</div>					
										<div class="panel-body">
											<div class="row">
												<div class="col-md-8 justify"><b>Objectif :</b> connaître la situation personnelle des apprenant.es et mesurer leur capacité financière et opérationnelle à suivre la formation dans son intégralité. Important: bien dédramatiser la situation en prévenant que nous allons poser des questions intimes mais que cela n’est pas du tout éliminatoire : le but est que nous puissions mettre en place dés le début des aides et un accompagnement adapté si besoin. Le but étant d’éviter un décrochage durant la formation.</div>
												<div class="col-md-2">
													<select name="pre_admin" id="pre_admin" class="form-control">
														<option value="2" @if(isset($selection->pre_admin) && $selection->pre_admin == 2) selected="selected" @endif>++</option>									
														<option value="1" @if(isset($selection->pre_admin) && $selection->pre_admin == 1) selected="selected" @endif>+</option>
														<option value="0" @if((isset($selection->pre_admin) && $selection->pre_admin == 0) || !isset($selection->pre_admin) || empty($selection->pre_admin)) selected="selected" @endif>&lt;&gt;</option>
														<option value="-1" @if(isset($selection->pre_admin) && $selection->pre_admin == -1) selected="selected" @endif>-</option>
														<option value="-2" @if(isset($selection->pre_admin) && $selection->pre_admin == -2) selected="selected" @endif>--</option>
													</select>
												</div>
												<div class="col-md-2">
													<select name="admin" id="admin" class="form-control">
														<option value="2" @if(isset($selection->admin) && $selection->admin == 2) selected="selected" @endif>++</option>									
														<option value="1" @if(isset($selection->admin) && $selection->admin == 1) selected="selected" @endif>+</option>
														<option value="0" @if((isset($selection->admin) && $selection->admin == 0) || !isset($selection->admin) || empty($selection->admin)) selected="selected" @endif>&lt;&gt;</option>
														<option value="-1" @if(isset($selection->admin) && $selection->admin == -1) selected="selected" @endif>-</option>
														<option value="-2" @if(isset($selection->admin) && $selection->admin == -2) selected="selected" @endif>--</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="panel panel-default">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-8">Pôle Motivation</div>
												<div class="col-md-2">Pré-séléction</div>
												<div class="col-md-2">Entretiens</div>
											</div>
										</div>					
										<div class="panel-body">
											<div class="row">
												<div class="col-md-8 justify"><b>Objectif :</b> Mesurer la motivation des candidates, découvrir leur personnalité.
</div>
												<div class="col-md-2">
													<select name="pre_motiv" id="pre_motiv" class="form-control">
														<option value="2" @if(isset($selection->pre_motiv) && $selection->pre_motiv == 2) selected="selected" @endif>++</option>									
														<option value="1" @if(isset($selection->pre_motiv) && $selection->pre_motiv == 1) selected="selected" @endif>+</option>
														<option value="0" @if((isset($selection->pre_motiv) && $selection->pre_motiv == 0) || !isset($selection->pre_motiv) || empty($selection->pre_motiv)) selected="selected" @endif>&lt;&gt;</option>
														<option value="-1" @if(isset($selection->pre_motiv) && $selection->pre_motiv == -1) selected="selected" @endif>-</option>
														<option value="-2" @if(isset($selection->pre_motiv) && $selection->pre_motiv == -2) selected="selected" @endif>--</option>
													</select>
												</div>
												<div class="col-md-2">
													<select name="motiv" id="motiv" class="form-control">
														<option value="2" @if(isset($selection->motiv) && $selection->motiv == 2) selected="selected" @endif>++</option>									
														<option value="1" @if(isset($selection->motiv) && $selection->motiv == 1) selected="selected" @endif>+</option>
														<option value="0" @if((isset($selection->motiv) && $selection->motiv == 0) || !isset($selection->motiv) || empty($selection->motiv)) selected="selected" @endif>&lt;&gt;</option>
														<option value="-1" @if(isset($selection->motiv) && $selection->motiv == -1) selected="selected" @endif>-</option>
														<option value="-2" @if(isset($selection->motiv) && $selection->motiv == -2) selected="selected" @endif>--</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="panel panel-default">
										<div class="panel-heading">
											<div class="row">
												<div class="col-md-8">Pôle Technique</div>
												<div class="col-md-2">Pré-séléction</div>
												<div class="col-md-2">Entretiens</div>
											</div>
										</div>					
										<div class="panel-body">
											<div class="row">
												<div class="col-md-8 justify"><b>Objectif :</b> connaître les acquis des candidat.tes en matière de culture et de techniques du numérique et s’assurer que la personne possède bien les pré-requis nécessaires pour suivre la formation.
</div>
												<div class="col-md-2">
													<select name="pre_techn" id="pre_techn" class="form-control">
														<option value="2" @if(isset($selection->pre_techn) && $selection->pre_techn == 2) selected="selected" @endif>++</option>									
														<option value="1" @if(isset($selection->pre_techn) && $selection->pre_techn == 1) selected="selected" @endif>+</option>
														<option value="0" @if((isset($selection->pre_techn) && $selection->pre_techn == 0) || !isset($selection->pre_techn) || empty($selection->pre_techn)) selected="selected" @endif>&lt;&gt;</option>
														<option value="-1" @if(isset($selection->pre_techn) && $selection->pre_techn == -1) selected="selected" @endif>-</option>
														<option value="-2" @if(isset($selection->pre_techn) && $selection->pre_techn == -2) selected="selected" @endif>--</option>
													</select>
												</div>
												<div class="col-md-2">
													<select name="techn" id="techn" class="form-control">
														<option value="2" @if(isset($selection->techn) && $selection->techn == 2) selected="selected" @endif>++</option>									
														<option value="1" @if(isset($selection->techn) && $selection->techn == 1) selected="selected" @endif>+</option>
														<option value="0" @if((isset($selection->techn) && $selection->techn == 0) || !isset($selection->techn) || empty($selection->techn)) selected="selected" @endif>&lt;&gt;</option>
														<option value="-1" @if(isset($selection->techn) && $selection->techn == -1) selected="selected" @endif>-</option>
														<option value="-2" @if(isset($selection->techn) && $selection->techn == -2) selected="selected" @endif>--</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<input type="submit" value="Enregistrer" class="form-control">
									<input type="reset" value="Reset" class="form-control">
									<br />
									<div class="panel panel-default">
								        <!-- /.panel-heading -->
								        <div class="panel-heading">
											Résumé des apréciations 
										</div>		
								        <div class="panel-body">
											<div id="morris-rapport-promo"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div class="panel panel-default">
										<div class="panel-heading">Notes/Commentaires</div>					
										<div class="panel-body">
							 	 			<textarea name="Commentaires" class="form-control" id="Commentaires" placeholder="Commentaires" data-sample="1">{{ $candidat->Commentaires }}</textarea>
								  			{!! $errors->first('Commentaires', '<small class="help-block">:message</small>') !!}
										</div>
									</div>
								</div>
							</div>
						</form>
                    	<!--  -->
                    </div>

                    <!-- Administratif -->
                    <div class="tab-pane fade" id="administratif">
                    	<br />
                    	<div class="panel panel-default">
							<div class="panel-heading">Documents administratifs</div>					
							<div class="panel-body">
								<form name="candidatSexe" method="post" action="{{ route('candidat.docAdmin') }}" class="form-horizontal panel" enctype="multipart/form-data">
							 	 {!! csrf_field() !!}
							 	 {{ method_field('POST') }}
							 	 <input type="hidden" name="id" value="{{ $candidat->id }}">
							 		<div class="row">
							 		<!-- CNI -->
							 			<div class="col-md-4"> 
							 				<div class="panel panel-default">
							 					<div class="panel-heading">Carte nationnale d'identité</div>
							 					<div class="panel-body">
								 					<?php $exist = false; ?>
											 		@foreach($docAdminExt as $ext)
											 		@if(file_exists(storage_path("app")."/administratifs/cni/".$candidat->id.".".$ext))
											 		<?php $exist = true; ?>		
														<a href="{{ "../storage/app/administratifs/cni/".$candidat->id.".".$ext }}" target="_blank"><img alt="CNI {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ "../storage/app/administratifs/cni/apercuImg.php?img=".$candidat->id.".".$ext }}" class="portrait"></a>
													@endif
											 		@endforeach
											 		@if(!$exist)
											 		<img alt="CNI {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="images/no_file.png" class="portrait">
											 		@endif
											 		<input type="file" name="cni">
							 					</div>
							 				</div>
							 			</div>

							 			<!-- Responsabilité Civile -->
							 			<div class="col-md-4"> 
							 				<div class="panel panel-default">
							 					<div class="panel-heading">Responsabilité Civile</div>
							 					<div class="panel-body">
								 					<?php $exist = false; ?>
											 		@foreach($docAdminExt as $ext)
											 		@if(file_exists(storage_path("app")."/administratifs/AssuranceRespCivile/".$candidat->id.".".$ext))
											 		<?php $exist = true; ?>		
														<a href="{{ "../storage/app/administratifs/AssuranceRespCivile/".$candidat->id.".".$ext }}" target="_blank"><img alt="Responsabilité Civile {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ "../storage/app/administratifs/AssuranceRespCivile/apercuImg.php?img=".$candidat->id.".".$ext }}" class="portrait"></a>
													@endif
											 		@endforeach
											 		@if(!$exist)
											 		<img alt="CNI {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="images/no_file.png" class="portrait">
											 		@endif
											 		<input type="file" name="AssuranceRespCivile">
							 					</div>
							 				</div>
							 			</div>

							 			<!-- Assurance maladie -->
							 			<div class="col-md-4"> 
							 				<div class="panel panel-default">
							 					<div class="panel-heading">Assurance maladie</div>
							 					<div class="panel-body">
								 					<?php $exist = false; ?>
											 		@foreach($docAdminExt as $ext)
											 		@if(file_exists(storage_path("app")."/administratifs/AssMaladie/".$candidat->id.".".$ext))
											 		<?php $exist = true; ?>		
														<a href="{{ "../storage/app/administratifs/AssMaladie/".$candidat->id.".".$ext }}" target="_blank"><img alt="Assurance maladie {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ "../storage/app/administratifs/AssMaladie/apercuImg.php?img=".$candidat->id.".".$ext }}" class="portrait"></a>
													@endif
											 		@endforeach
											 		@if(!$exist)
											 		<img alt="CNI {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="images/no_file.png" class="portrait">
											 		@endif
											 		<input type="file" name="AssMaladie">
							 					</div>
							 				</div>
							 			</div>
							 		</div>

							 		<div class="row">
							 		<!-- Justificatif domicil -->
							 			<div class="col-md-4"> 
							 				<div class="panel panel-default">
							 					<div class="panel-heading">Justificatif domicile</div>
							 					<div class="panel-body">
								 					<?php $exist = false; ?>
											 		@foreach($docAdminExt as $ext)
											 		@if(file_exists(storage_path("app")."/administratifs/JustifDomicile/".$candidat->id.".".$ext))
											 		<?php $exist = true; ?>		
														<a href="{{ "../storage/app/administratifs/JustifDomicile/".$candidat->id.".".$ext }}" target="_blank"><img alt="Justificatif domicile {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ "../storage/app/administratifs/cni/apercuImg.php?img=".$candidat->id.".".$ext }}" class="portrait"></a>
													@endif
											 		@endforeach
											 		@if(!$exist)
											 		<img alt="CNI {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="images/no_file.png" class="portrait">
											 		@endif
											 		<input type="file" name="JustifDomicile">
							 					</div>
							 				</div>
							 			</div>

							 			<!-- Suivi Formation -->
							 			<div class="col-md-4"> 
							 				<div class="panel panel-default">
							 					<div class="panel-heading">Attestation suivi de formation</div>
							 					<div class="panel-body">
								 					<?php $exist = false; ?>
											 		@foreach($docAdminExt as $ext)
											 		@if(file_exists(storage_path("app")."/administratifs/AttestaionSuiviDeFormation/".$candidat->id.".".$ext))
											 		<?php $exist = true; ?>		
														<a href="{{ "../storage/app/administratifs/AttestaionSuiviDeFormation/".$candidat->id.".".$ext }}" target="_blank"><img alt="Attestation suivi de formation {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="{{ "../storage/app/administratifs/AttestaionSuiviDeFormation/apercuImg.php?img=".$candidat->id.".".$ext }}" class="portrait"></a>
													@endif
											 		@endforeach
											 		@if(!$exist)
											 		<img alt="CNI {{ ucfirst(strtolower($candidat->Prenom)) }} {{ strtoupper($candidat->Nom) }}" src="images/no_file.png" class="portrait">
											 		@endif
											 		<input type="file" name="AttestaionSuiviDeFormation">
							 					</div>
							 				</div>
							 			</div>

							 			<!-- Validation formulaire -->
							 			<div class="col-md-4"> 
							 				<input type="submit" name="valider" value="Envoyer les documents" class="form-control">
							 				<br />
							 				<input type="reset" name="reset" value="Reset" class="form-control">
							 			</div>
							 		</div>
							 	</form>
							</div>
						</div>
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
</div>
@endsection
<?php 
	$tab['pre_admin'] = "Pôle administratif (pre)" ;
	$tab['pre_motiv'] = "Pôle motivation (pre)" ;
	$tab['pre_techn'] = "Pôle technique (pre)" ;
	$tab['admin'] = "Pôle administratif" ;
	$tab['motiv'] = "Pôle motivation" ;
	$tab['techn'] = "Pôle technique" ;
?>
@section("script")
	<script>

	  jQuery(document).ready(function(){

	  	jQuery(function() {
			var donneeNotes = [
		        @foreach($selections as $key => $note)
	        	{
	        		y: "{!! $tab[$key] !!}",
	        		a: {!! $note !!},
	        		b: {!! empty($selection_promo->$key) ? 0 : $selection_promo->$key !!}
	        	},
	        	@endforeach
	        ];
			//donneeNotes.pop();
			
		    Morris.Bar({
		        element: 'morris-rapport-promo',
		        data: donneeNotes,
		        xkey: 'y',
		        ykeys: ['a', 'b'],
		        labels: ['Notes candidats', 'Moyenne promo'],
		        xLabelAngle: 35,
	        	resize: true
		    });

		});

	  	var commentaires = CKEDITOR.replace( 'Commentaires' );
	  	var newEval = CKEDITOR.replace( 'newEval' );

	  	commentaires.on('change', function(ev){

		  	jQuery.ajax({
		        method: 'post',	        
		        url: '{{ route('candidat.updateAjax', $candidat->id) }}',
		        data: {
		        	'Commentaires' : this.getData(),
		        	'_token' : jQuery("#form_notes_select input[name='_token']").val()
		        },
		        dataType: "text"
		    })
		    .fail(function(data) {
		        //jQuery("#Commentaires").val("bug");
		        console.log("bug");
		    });
		  });

  		// function timer(){
  		// 	if(jQuery("#selec").hasClass("active"))
  		// 	{
  		// 		//alert("test");
  		// 		jQuery.ajax({
			 //        method: 'post',	        
			 //        url: '{{ route('candidat.display', $candidat->id) }}',
			 //        data: {
			 //        	'Commentaires' : commentaires.getData(),
			 //        	'_token' : jQuery("#form_notes_select input[name='_token']").val()
			 //        },
			 //        dataType: "html"
			 //    })
			 //    .done(function(data) {
			 //    	//alert(data);
			 //    	if(data != "]]}}@@@@{{[["){
			 //    		CKEDITOR.instances.Commentaires.setData(data);
			 //    	}
			 //    })
			 //    .fail(function(data) {
			 //        //jQuery("#Commentaires").val("bug");
			 //        console.log("bug");
			 //    });
  		// 	}

  		// 	setTimeout(timer, 10000);
  		// };

  		// setTimeout(timer, 10000);

	  });
	  
	  </script>
@endsection