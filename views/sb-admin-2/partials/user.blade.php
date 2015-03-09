<div class="nav navbar-top-links navbar-right">
    <img src="//www.gravatar.com/avatar/{!! md5(Auth::user()->email) !!}/?s=50" alt="" >
</div>



<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> {!! Auth::user()->name !!}<i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Support Links</li>
            <li><a href="http://lasallecms.com" target="_blank"> LaSalleCMS.com</a></li>
        </ul>
    </li>
</ul>

<!--
<div class="nav navbar-nav navbar-right navbar-brand">
    <img src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}/?s=30" alt="" >
</div>
-->