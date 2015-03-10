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

<!--
Layout Options

AdminLTE 2.0 provides a set of options to apply to your main layout. Each on of these classes can be added to the body tag to get the desired goal.

Fixed: use the class .fixed to get a fixed header and sidebar.
Collapsed Sidebar: use the class .sidebar-collapse to have a collapsed sidebar upon loading.
Boxed Layout: use the class .layout-boxed to get a boxed layout that stretches only to 1250px.
Top Navigation use the class .layout-top-nav to remove the sidebar and have your links at the top navbar.
Note: you cannot use both layout-boxed and fixed at the same time. Anything else can be mixed together.

Skins

Skins can be found in the dist/css/skins folder. Choose and the skin file that you want then add the appropriate class to the body tag to change the template's appearance. Here is the list of available skins:

skin-blue
skin-yellow
skin-purple
skin-green
skin-red
skin-black
-->


<body class="skin-purple fixed sidebar-collapse">

    <!-- site wrapper (yeah, shouldn't have an inline style, oh my!) -->
    <div class="wrapper" style="background-color: #ffffff;">

        {{-- top nav --}}
        @section('topnav')
            @include('lasallecmsadmin::bob1.layouts.header_navbar')
        @show


        {{-- left sidebar --}}
        @section('leftsidebar')
            @include('lasallecmsadmin::bob1.layouts.sidebar_left')
        @show

        {{-- Content --}}
        @yield('content')



        {{-- Footer Content --}}
        @section('footer')
            @include('lasallecmsadmin::bob1.layouts.footer_content')
        @show


        {{-- Footer JS --}}
        @section('footer_scripts')
                @include('lasallecmsadmin::bob1.layouts.footer_scripts')
        @show

    </div> <!-- /.wrapper -->


</body>

</html>


