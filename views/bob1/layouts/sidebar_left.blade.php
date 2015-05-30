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
                <a href="{{{ route('admin.home') }}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> </i>
                </a>
            </li>

            <li class="treeview"><hr></li>

            <li class="treeview">
                <a href="{{{ route('admin.posts.index') }}}"">
                    <i class="fa fa-book"></i> <span>Posts</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{{ route('admin.postupdates.index') }}}">
                    <i class="fa fa-briefcase"></i> <span>Post Updates</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{{ route('admin.categories.index') }}}">
                    <i class="fa fa-folder-open"></i> <span>Categories</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{{ route('admin.tags.index') }}}">
                    <i class="fa fa-tags"></i> <span>Tags</span>
                </a>
            </li>

            <li class="treeview"><hr></li>


            @if ( class_exists(\Lasallecrm\Lasallecrmadmin\Version::class) )

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Customer Management</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">

                        <li><a href="{{{ route('admin.crmaddresses.index') }}}"><i class="fa fa-user"></i> Addresses</a></li>
                        <li><a href="{{{ route('admin.crmcompanies.index') }}}"><i class="fa fa-user"></i> Companies/Orgs</a></li>
                        <li><a href="{{{ route('admin.crmemails.index') }}}"><i class="fa fa-user"></i> Emails</a></li>
                        <li><a href="{{{ route('admin.crmpeoples.index') }}}"><i class="fa fa-user"></i> People</a></li>
                        <li><a href="{{{ route('admin.crmsocials.index') }}}"><i class="fa fa-user"></i> Social Sites</a></li>
                        <li><a href="{{{ route('admin.crmtelephones.index') }}}"><i class="fa fa-user"></i> Telephone</a></li>
                        <li><a href="{{{ route('admin.crmwebsites.index') }}}"><i class="fa fa-user"></i> Websites</a></li>

                        <li><a href="{{{ route('admin.luaddresses.index') }}}"><i class="fa fa-columns"></i> Address Types Lookup Table</a></li>
                        <li><a href="{{{ route('admin.luemails.index') }}}"><i class="fa fa-columns"></i> Email Types Lookup Table</a></li>
                        <li><a href="{{{ route('admin.lusocials.index') }}}"><i class="fa fa-columns"></i> Social Types Lookup Table</a></li>
                        <li><a href="{{{ route('admin.lutelephones.index') }}}"><i class="fa fa-columns"></i> Telephone Types Lookup Table</a></li>
                        <li><a href="{{{ route('admin.luwebsites.index') }}}"><i class="fa fa-columns"></i> Website Types Lookup Table</a></li>
                    </ul>
                </li>

                <li class="treeview"><hr></li>
            @endif


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Utilities</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#l"><i class="fa fa-cloud-upload"></i> Backup</a></li>
                </ul>
            </li>

            <li class="treeview"><hr></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ route('admin.users.index') }}}"><i class="fa fa-users"></i> Users</a></li>
                    <li><a href="{{{ route('admin.usergroups.index') }}}"><i class="fa fa-group"></i> User Groups Lookup Table</a></li>
                </ul>
            </li>

            <li class="treeview"><hr></li>

            <li class="treeview">
                <a href="{{{ route('admin.logout') }}}">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>

            <li class="treeview"><hr></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
