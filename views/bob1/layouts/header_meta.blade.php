<?php
// TODO: social meta tags
?>
    <!-- START: meta -->
    <meta charset="utf-8">


    <!-- title tag -->
    <!-- http://www.netlingo.com/tips/html-code-cheat-sheet.php -->
    @if ( isset($pagetitle) )
        <title>{{{ $pagetitle }}} &verbar; {{{ Config::get('lasallecms.site_name') }}} Admin</title>
    @else
        <title>{{{ Config::get('lasallecms.site_name') }}}</title>
    @endif


    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>



<meta name="description" content="">
<meta name="author" content="">




<!-- This is the traditional favicon.
	 - size: 16x16 or 32x32
	 - transparency is OK
	 - see wikipedia for info on browser support: http://mky.be/favicon/
-->
<link rel="icon" type="image/png" href="{{{ Config::get('app.url') }}}/ico/{{{ Config::get('lasallecmsfrontend.icon') }}}">



<!-- END: meta -->






