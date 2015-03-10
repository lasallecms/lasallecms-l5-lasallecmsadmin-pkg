<!-- Bootstrap -->
<!-- from http://getbootstrap.com/getting-started -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- http://fortawesome.github.io/Font-Awesome/get-started/ -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<!-- DataTables CSS (http://datatables.net/manual/installation) -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.css">


<!-- Custom styles for this template http://getbootstrap.com/examples/navbar-fixed-top/-->
@foreach (File::allFiles(public_path().'/packages/lasallecmsadmin/bob1/css/') as $cssfile)
    <link media="all" type="text/css" rel="stylesheet" href="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/bob1/css/{{ basename($cssfile) }}" >
@endforeach



