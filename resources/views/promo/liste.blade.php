<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rémi LANNEY">
    <base href="{{ config('app.url') }}">

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
    <style>
    	th, td{
    		height: 3em;
    	}
    	th{
    		
    	}
    </style> 

</head>

<body>

    <div id="wrapper">
        <div id="page-wrapper">        
            <table width="100%" cellpadding="0" cellspacing="0">
            	<thead>
		        	<tr>
		        		<th>Nom</th>
		        		<th>Date</th>
		        		<th>Signature</th>
		        	</tr>
            	</thead>
            	<tbody>
            		@foreach($liste as $candidat)
            		<tr>
            			<td>{{ strtoupper($candidat->Nom) }} {{ ucfirst(strtolower($candidat->Prenom)) }}</td>
            			<td>{{ date("d/m/Y") }}</td>
            			<td>&nbsp;</td>
            		</tr>
            		@endforeach
            	</tbody>
            	<tfoot>
		        	<tr>
		        		<th>Nom</th>
		        		<th>Date</th>
		        		<th>Signature</th>
		        	</tr>
            	</tfoot>
            </table>
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
    

</body>

</html>

