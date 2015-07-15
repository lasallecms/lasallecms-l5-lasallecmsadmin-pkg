<!-- jQuery 2.1.3 (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- SlimScroll -->
<script src="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>

<!-- FastClick -->
<script src='"{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/fastclick/fastclick.min.js'></script>

<!-- AdminLTE App -->
<script src="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/dist/js/demo.js" type="text/javascript"></script>



<!-- DataTables (http://datatables.net/manual/installation) -->
    <link media="all" type="text/css" rel="stylesheet" href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/datatables/dataTables.bootstrap.js }}" >

<link media="all" type="text/css" rel="stylesheet" href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/datatables/jquery.dataTables.js }}" >


*************************





<!-- custom-ajax.js for forms https://laracasts.com/lessons/javascript-conveniences -->
@foreach (File::allFiles(public_path().'/packages/lasallecmsadmin/bob1/js/') as $jsfile)
    <link media="all" type="text/css" rel="stylesheet" href="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/js/{{ basename($jsfile) }}" >
@endforeach


<!-- DataTables (http://datatables.net/manual/installation) -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>




<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->



<!-- prettyprint -->
<!-- http://google-code-prettify.googlecode.com/svn/trunk/README.html -->
<!--
<script src="http://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
-->

<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>


<!-- http://datatables.net/manual/options -->
<script>
    $('#table_id').DataTable( {
    scrollY: 400
    } );
</script>