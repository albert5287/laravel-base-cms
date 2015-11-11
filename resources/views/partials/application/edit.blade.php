<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{$tab === 'app' ? 'active' : ''}}"><a href="{{action('ApplicationController@edit',[$application->id])}}">{{trans('strings.LABEL_APPLICATION')}}</a></li>
                @if(checkIfUserHavePermissions('show','user'))
                    <li class="{{$tab === 'user' ? 'active' : ''}}"><a href="{{url('apps/users/'.$application->id)}}">{{trans('strings.LABEL_USERS')}}</a></li>
                @endif
                @if(checkIfUserHavePermissions('show','role'))
                    <li class="{{$tab === 'role' ? 'active' : ''}}"><a href="{{url('apps/roles/'.$application->id)}}">{{trans('strings.LABEL_ROLES')}}</a></li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_{{$tab}}">
                    @include($view)
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->
    </div>
</div>