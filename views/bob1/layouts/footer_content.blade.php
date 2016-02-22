@inject('version', 'Lasallecms\Lasallecmsadmin\Version')

<br /><br />

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> {{{ $version->version() }}}
    </div>
    <br />
    <div class="pull-right hidden-xs">
        <a href="{{{ route('admin.installedpackages') }}}">List of LaSalle Software installed packages</a>
    </div>
    <strong>You are using the {{{ $version->packageName() }}}.<br />Crafted with love, with the <a href="http://laravel.com" target="_blank">Laravel Framework v5.1</a>. Copyright © 2015 - 2016
</footer>
</div><!-- ./wrapper -->

</body>
</html>











