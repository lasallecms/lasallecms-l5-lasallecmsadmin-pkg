<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <!--
            <li class="header">MAIN NAVIGATION</li>
            -->


            <!-- icons at http://fortawesome.github.io/Font-Awesome/icons/#web-application -->

            <li class="treeview">
                <a href="{{{ Config::get('app.url') }}}/admin">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> </i>
                </a>

            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Posts</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-briefcase"></i> <span>Post Updates</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle"></i> <span>Categories</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{{ Config::get('app.url') }}}/admin/tags">
                    <i class="fa fa-tags"></i> <span>Tags</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Utilities</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#l"><i class="fa fa-cloud-upload"></i> Backup</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="admin/logout">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
