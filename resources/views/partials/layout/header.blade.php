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
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="{{url('auth/logout')}}">
                        <!-- The user image in the navbar-->
                        <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>-->
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{Auth::user()->username}} logout</span>
                    </a>
                </li>
            </ul>
        </div>

    </nav>
</header>