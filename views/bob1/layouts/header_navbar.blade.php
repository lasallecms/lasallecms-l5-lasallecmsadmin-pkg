<!-- =============================================== -->

<header class="main-header">
    <a href="{{{ Config::get('app.url') }}}/admin" class="logo"><b>{{{ Config::get('lasallecms.site_name') }}}</b></a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="//www.gravatar.com/avatar/{!! md5(Auth::user()->email) !!}/?s=30" alt="" class="user-image">
                        <span class="hidden-xs">{{{ Auth::user()->name }}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="btn btn-default btn-flat"><b>Edit</b></a></li>
                        <li><a href="admin/logout" class="btn btn-default btn-flat"><b>Logout</b></a></li>
                        <!--
                        <li class="divider"></li>
                        -->
                        <li><a href="http://lasallecms.com" target="_blank" class="btn btn-default btn-flat"><b>LaSalleCMS.com</b></a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>