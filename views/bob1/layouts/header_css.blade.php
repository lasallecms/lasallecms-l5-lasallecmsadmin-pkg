<!-- Bootstrap 3.3.4 -->
<!-- from http://getbootstrap.com/getting-started -->

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<!-- Ionicons -->
<!--
<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
-->

<!-- jQuery 2.1.3 (necessary for Bootstrap's JavaScript plugins) -->
<!-- must load first! -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- bootstrap multiselect css and js (https://github.com/davidstutz/bootstrap-multiselect) -->
<link href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf8" src="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/js/bootstrap-multiselect.js"></script>

<!-- DataTables CSS (http://datatables.net/manual/installation) -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.css">

<!--
    <link href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    -->

<!-- Theme style -->
<link href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />

<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />


<!-- Custom styles for this template http://getbootstrap.com/examples/navbar-fixed-top/-->
@foreach (File::allFiles(public_path().'/packages/lasallecmsadmin/bob1/css/') as $cssfile)
    <link media="all" type="text/css" rel="stylesheet" href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/css/{{ basename($cssfile) }}" >
@endforeach

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
