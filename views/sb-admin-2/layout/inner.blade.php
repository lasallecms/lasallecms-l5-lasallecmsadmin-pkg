@extends('lasallecmsadmin::sb-admin-2.layout.base')

@section('content')
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('lasallecmsadmin::sb-admin-2.partials.header')
            @include('lasallecmsadmin::sb-admin-2.partials.user')
            @include('lasallecmsadmin::sb-admin-2.partials.menu')
        </nav>
        <div id="page-wrapper">
            @yield('innerContent')
        </div>
    </div>
@stop
