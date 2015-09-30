<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            @foreach(getActiveModules() as $module)
                <li class="{{HTML::isActive($module->name)}}"><a href="{{action($module->class.'Controller@index')}}"><span>{{$module->title}}</span></a> </li>
            @endforeach
            {{--<li class="{{HTML::isActive('home')}}"><a href="{{action('HomeController@index')}}"><span>Home</span></a> </li>
            <li class="{{HTML::isActive('languages')}}"><a href="{{action('LanguageController@index')}}"><span>Languages</span></a> </li>
            <li class="{{HTML::isActive('kategorie')}}"><a href="{{action('KategorieController@index')}}"><span>Kategorie</span></a> </li>
            <li class="{{HTML::isActive('impulse')}}"><a href="{{action('GedankenController@index')}}"><span>Impulse</span></a> </li>
            <li class="{{HTML::isActive('termine')}}"><a href="{{action('ImpulseController@index')}}"><span>Termine</span></a> </li>
            <li class="{{HTML::isActive('users')}}"><a href="{{action('UserController@index')}}"><span>Users</span></a> </li>--}}

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>