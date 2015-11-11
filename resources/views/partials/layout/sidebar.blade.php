<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            @foreach(getAvailableModulesForAUser(Auth::user()) as $module)
                @if(checkIfUserHavePermissions('show', $module->class))
                    <li class="{{HTML::isActive($module->name)}}"><a href="{{action($module->class.'Controller@index')}}"><span>{{$module->title}}</span></a> </li>
                @endif
            @endforeach
            <li class="{{HTML::isAContentModuleActive()}}"><a href="{{action('ContentController@index')}}"><span>{{trans('strings.CONTENT_MODULE_LABEL')}}</span></a> </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>