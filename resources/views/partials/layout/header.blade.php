<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{url('home')}}" class="logo">{{CMS_TITLE}}</a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @role('super.admin')
                    @include('partials.layout.dropdownApps')
                @endrole
                @include('partials.layout.dropdownUsers')
            </ul>
        </div>

    </nav>
</header>