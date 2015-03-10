<!doctype html>
<html lang="en">

<head>

    @section('meta')
        @include('lasallecmsadmin::bob1.layouts.header_meta')
    @show


    @section('styles')
        @include('lasallecmsadmin::bob1.layouts.header_css')
    @show


</head>

<body>

    {{-- Navigation --}}
    @section('topnav')
        @include('lasallecmsadmin::bob1.layouts.header_navbar')
    @show



    <div id="page-wrapper">

    {{-- Content --}}
    @yield('content')

    </div>



    {{-- Footer Content --}}
    @section('footer')
        @include('lasallecmsadmin::bob1.layouts.footer_content')
    @show


    {{-- Footer JS --}}
    @section('footer_scripts')
            @include('lasallecmsadmin::bob1.layouts.footer_scripts')
    @show


</body>

</html>


