@inject('version', 'Lasallecms\Lasallecmsadmin\Version')

<br /><br />

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> {{{ $version->version() }}}
        <br />
        <a href="{{{ route('admin.installedpackages') }}}"><i class="fa fa-book fa-fw"></i><span>List of LaSalle Software installed packages</span></a><
    </div>
    <strong>You are using the {{{ $version->packageName() }}}.<br />Crafted with love, with the <a href="http://laravel.com" target="_blank">Laravel Framework v5.1</a>. Copyright © 2015 - 2016
</footer>
</div><!-- ./wrapper -->

</body>
</html>











