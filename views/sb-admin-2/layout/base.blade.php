<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{{ $pagetitle }}} | {{{ Config::get('lasallecmsadmin.site_name') }}} Admin</title>


    @foreach (File::allFiles(public_path().'/sb-admin-2/css/') as $cssfile)
        <link media="all" type="text/css" rel="stylesheet" href="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/{{{ Config::get('lasallecmsadmin.admin_template_name') }}}/css/{{ basename($cssfile) }}" >
    @endforeach


    <!-- js folder -->
    @foreach (File::Files(public_path().'/packages/lasallecmsadmin/sb-admin-2/js/') as $jsfile)
        <script src="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/{{{ Config::get('lasallecmsadmin.admin_template_name') }}}/js/{{ basename($jsfile) }}"></script>
    @endforeach

    <!-- js/plugins/dataTables folder -->
    @foreach (File::Files(public_path().'/packages/lasallecmsadmin/sb-admin-2/js/plugins/dataTables/') as $jsfile)
        <script src="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/{{{ Config::get('lasallecmsadmin.admin_template_name') }}}/js/plugins/dataTables/{{ basename($jsfile) }}"></script>
    @endforeach

    <!-- js/metisMenu folder -->
    @foreach (File::Files(public_path().'/packages/lasallecmsadmin/sb-admin-2/js/plugins/metisMenu/') as $jsfile)
        <script src="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/{{{ Config::get('lasallecmsadmin.admin_template_name') }}}/js/plugins/metisMenu/{{ basename($jsfile) }}"></script>
    @endforeach

    <!-- js/morris folder -->
    @foreach (File::Files(public_path().'/packages/lasallecmsadmin/sb-admin-2/js/plugins/morris/') as $jsfile)
        <script src="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/{{{ Config::get('lasallecmsadmin.admin_template_name') }}}/sb-admin-2/js/plugins/morris/{{ basename($jsfile) }}"></script>
    @endforeach

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

@yield('content')

</body>
</html>