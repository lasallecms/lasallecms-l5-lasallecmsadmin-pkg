@inject('version', 'Lasallecms\Lasallecmsadmin\Version')

<br /><br />

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> {{{ $version->version() }}}
    </div>
    <strong>You are using {{{ $version->packageName() }}},<br />crafted with love with the Laravel Framework v5.1. Copyright © 2015
</footer>
</div><!-- ./wrapper -->

</body>
</html>











