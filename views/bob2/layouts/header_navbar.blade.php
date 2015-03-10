<!-- START: Fixed navbar -->
<!-- http://getbootstrap.com/examples/navbar-fixed-top -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{{ route('admin.home') }}}">{{{ Config::get('lasallecms.site_name') }}}</a>
        </div>

        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Posts<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>Steyne</li>
                        <li>Rush</li>
                        <li class="divider"></li>
                        <li>Levin</li>

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>JEB</li>
                        <li>RSL</li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tags<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>JEB</li>
                        <li>RSL</li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>U1</li>
                        <li>U2</li>
                    </ul>
                </li>


            </ul>




            <div class="nav navbar-nav navbar-right navbar-brand">
                <div class="navbar-collapse collapse">

                    <ul class="nav navbar-nav" style="position:relative;top:-15px;">


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{{ Auth::user()->name }}}<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"> Edit</a></li>
                                <li class="divider"></li>
                                <li><a href="{{{ route('admin.logout') }}}"> Logout</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Support Links</li>
                                <li><a href="http://lasallecms.com" target="_blank"> LaSalleCMS.com</a></li>
                            </ul>
                        </li>
                    </ul>

                </div><!--navbar-collapse collapse -->
            </div><!--nav navbar-nav navbar-right navbar-brand -->


            <div class="nav navbar-nav navbar-right navbar-brand">
                <img style="position:relative;top:-15px;"  src="//www.gravatar.com/avatar/{{{ md5(Auth::user()->email) }}}/?s=50" alt="" >
            </div>


        </div><!--navbar-collapse collapse -->


    </div><!-- container -->
</div><!-- navbar navbar-default navbar-fixed-top -->
<!-- END: Fixed navbar -->

<!-- START SIDENAV -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="flot.html">Flot Charts</a>
                    </li>
                    <li>
                        <a href="morris.html">Morris.js Charts</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
            </li>
            <li>
                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="panels-wells.html">Panels and Wells</a>
                    </li>
                    <li>
                        <a href="buttons.html">Buttons</a>
                    </li>
                    <li>
                        <a href="notifications.html">Notifications</a>
                    </li>
                    <li>
                        <a href="typography.html">Typography</a>
                    </li>
                    <li>
                        <a href="icons.html"> Icons</a>
                    </li>
                    <li>
                        <a href="grid.html">Grid</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a href="#">Third Level <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="blank.html">Blank Page</a>
                    </li>
                    <li>
                        <a href="login.html">Login Page</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>

<!-- END SIDENAV -->

