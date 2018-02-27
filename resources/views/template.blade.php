<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rémi LANNEY">
    <base href="{{ config('app.url') }}">

    <title>@yield('titre')</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- jqueryUi CSS -->
    <link href="../vendor/jqueryUi/jquery-ui.min.css" rel="stylesheet">
<!--     <link href="../vendor/jqueryUi/jquery-ui.structure.min.css" rel="stylesheet"> -->
<!--     <link href="../vendor/jqueryUi/jquery-ui.theme.min.css" rel="stylesheet"> -->

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../vendor/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
    


    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">LISAE</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                @if (Auth::user()->privileges != "Users")
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-group fa-fw"></i> Les promos <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    	@foreach (DB::table('promos')->get() as $promo)
                    		@if(Auth::user()->privileges == "SuperAdmin" || $promo->user_id == Auth::user()->id ) 
	                    <li>
	                       <a href="{{ route('promo.edit', $promo->id) }}">
                                <div>
                                    <i class="fa fa-edit fa-fw"></i> {{ $promo->titre }}
                                </div>
                            </a>
                        </li>
                        	@endif
                        @endforeach
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('promo.create')}}">
                                <div>
                                    <i class="fa fa-edit fa-fw"></i> Créer une promo
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-group fa-fw"></i> L'équipe <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="{{ route('user.index') }}">
                                <div>
                                    <i class="fa fa-plus fa-fw"></i> Gérer les membres
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('user.create') }}">
                                <div>
                                    <i class="fa fa-plus fa-fw"></i> Créer un membre
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                @endif
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> 
                        <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('user.edit', [Auth::user()->id]) }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    	{{ csrf_field() }}
                    </form>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search..." id="search_appear">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="buttonsearch">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </span>
                            </div>
                            <form name="motorsearch" id="motorsearch" method="post" action="{{ route('searchMotot') }}">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <input type="hidden" name="search" id="search">
                            </form>
                            <!-- /input-group -->
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> @if(!empty(session("nom_promo"))) {!! session("nom_promo") !!} @else Choisir une promo @endif<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	@foreach (DB::table('promos')->get() as $promo)
		                    		@if(Auth::user()->privileges == "SuperAdmin" || $promo->user_id == Auth::user()->id || Auth::user()->promo_id == $promo->id ) 
			                    <li>
			                       <a href="{{ route('promo.show', $promo->id)}}"> <i class="fa fa-users fa-fw"></i> {{ $promo->titre }}</a>
		                        </li>
		                        	@endif
		                        @endforeach
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @if(!empty(Auth::user()->promo_id) || session('promo_id'))
		             	<li>
		             		<a href="#"><i class="fa fa-list fa-fw"></i> Liste {!! session("liste") !!}<span class="fa arrow"></span></a>
                     		<ul class="nav nav-second-level">
                     			<li>
		                             <a href="{{ route('candidat.liste', 'principale') }}"><i class="glyphicon glyphicon-ok"></i> Liste principale</a>
		                         </li>
		                         <li>
		                             <a href="{{ route('candidat.liste', 'attente') }}"><i class="glyphicon glyphicon-time"></i> Liste d'attente</a>
		                         </li>
		                         <li>
		                             <a href="{{ route('candidat.liste', 'negative') }}"><i class="glyphicon glyphicon-remove"></i> Liste refusé(s)</a>
		                         </li>
                     		</ul>
                    		<!-- /.nav-second-level -->
                 		</li> 
		             	<li>
                            <?php
                                if(session('liste') == "attente")  
                                    $c =  DB::table('candidats')
                                            ->where('promo_id', session('promo_id'))
                                            ->whereIn('liste', ['attente', 'candidat'])
                                            ->orderby('Nom', 'asc'); 
                                else
                                    $c =  DB::table('candidats')->where([['liste', session('liste')], ['promo_id', session('promo_id')]] )->orderby('Nom', 'asc'); 
                            ?>
		             		<a href="#"><i class="fa fa-users fa-fw"></i> Candidats ({{ $c->count()}})<span class="fa arrow"></span></a>
                     		<ul class="nav nav-second-level">
                     			@foreach ( $c->get() as $candidats )
                     			<li>
                     				<a href="{{ route('candidat.show', $candidats->id) }}"><i class="glyphicon glyphicon-user"></i> {{ strtoupper($candidats->Nom) }} {{ ucfirst(strtolower($candidats->Prenom)) }}</a>
                     			</li>
                     			@endforeach
                         		 <li class="divider">&nbsp;</li>
		                         <li>
		                             <a href="{{ route('candidat.import') }}"><i class="glyphicon glyphicon-import"></i> Importer des candidats</a>
		                         </li>
                                 @if(Auth::user()->privileges == "SuperAdmin")
                                 <li class="divider">&nbsp;</li>
                                 <li>
                                     <a href="{{ route('candidat.clearPromo', session('promo_id')) }}" onclick="if(!confirm('Êtes vous bien sûr ?')) return false;"><i class="glyphicon glyphicon-import"></i> Vider la promo</a>
                                 </li>
                                 @endif
                     		</ul>
                    		<!-- /.nav-second-level -->
                 		</li> 
		                <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Détails promo<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                     			<li>
                     				<a><i class="glyphicon glyphicon-stats"></i> {!! session("nom_promo") !!}</a>
                     			</li>
                     			<li>
                     				<a href="{{ route('absences.index') }}"><i class="glyphicon glyphicon-eye-close"></i> Enregistrer absences</a>
                     			</li>
                     			<li>
                     				<a href="{{ route('retards.index') }}"><i class="glyphicon glyphicon-time"></i> Enregistrer retards</a>
                     			</li>
                     			<li>
                     				<a href="{{ route('promo.trombi') }}"><i class="fa fa-group"></i> Trombinoscopes</a>
                     			</li>
                                <li>
                                    <a href="{{ route('promo.selec') }}"><i class="fa fa-bar-chart"></i> Selection</a>
                                </li>
                         		<li class="divider"></li>
		                        <li>
		                            <a href="#"><i class="glyphicon glyphicon-stats"></i> Statistiques <span class="fa arrow"></a>
		                            <ul class="nav nav-third-level">
		                     			<li>
		                     				<a href="{{ route('absences.stats') }}"><i class="glyphicon glyphicon-eye-close"></i> Absences</a>
		                     			</li>
		                     			<li>
		                     				<a href="{{ route('retards.stats') }}"><i class="glyphicon glyphicon-time"></i> Retards</a>
		                     			</li>
                                        <li>
                                            <a href="{{ route('docAdmin') }}"><i class="fa fa-file-o"></i> Documents administratifs</a>
                                        </li>
		                     			<li>
		                     				<a href="{{ route('stats') }}"><i class="fa fa-dashboard"></i> Divers</a>
		                     			</li>
		                     		</ul>
		                     		<!-- /.nav-third-level -->
		                        </li>
                     		</ul>
                     		<!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-briefcase fa-fw"></i> Insertion professionnelle<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('planning') }}"><i class="fa fa-address-card"></i> Planning</a>
                                </li>
                     			<li>
                     				<a href="{{ route('structure.index') }}"><i class="fa fa-address-card"></i> Entreprises</a>
                     			</li>
                                <li>
                                    <a href="{{ route('contacts.index') }}"><i class="fa fa-address-card"></i> Contacts</a>
                                </li>
                     		</ul>
                     		<!-- /.nav-second-level -->
                        </li>
		             	@endif 
                        
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('titre')</h1>
                    
                    @if(session()->has('ok'))
						<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
					@endif
					 @if(session()->has('error'))
						<div class="alert alert-danger alert-dismissible">{!! session('error') !!}</div>
					@endif
					@if(session()->has('information'))
						<div class="alert alert-warning alert-dismissible">{!! session('information') !!}</div>
					@endif
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            
            <!-- /.row -->
            @yield('content')
            <div class="clearboth"><br /></div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/jqueryUi/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    
    <!-- Flot Charts JavaScript -->
	<!--[if lte IE 8]><script src="../vendor/flot/excanvas.min.js"></script><![endif]-->
    <script src="../vendor/flot/jquery.flot.js"></script>
    <script src="../vendor/flot/jquery.flot.pie.js"></script>
    <script src="../vendor/flot/jquery.flot.tooltip.min.js"></script>
    <script src="../vendor/flot/jquery.flot.resize.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="../vendor/dist/js/sb-admin-2.js"></script>
    
    <!--  CKeditor -->
    <script src="../vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script>
        jQuery("#buttonsearch").click(function (e){
            jQuery("#search").val(jQuery("#search_appear").val());
            jQuery("#motorsearch").submit();
        });
        jQuery('#search_appear').keyup(function(e) {    
            if(e.keyCode == 13) { // KeyCode de la touche entrée
                jQuery("#search").val(jQuery("#search_appear").val());
                jQuery("#motorsearch").submit();
            }
        });
    </script>
    
    @yield('script')

</body>

</html>

