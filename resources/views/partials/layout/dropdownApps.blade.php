<li class="dropdown navbar-nav">
    <div class="btn-user-switch messages-menu">
        @if(Session::has('currentApp'))
            <a href="#" aria-expanded="false" class="no-padding-right">
                <i class="fa fa-mobile"></i>
                <span>{{Session::get('currentApp')->name}}</span>
            </a>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="fa fa-fw fa-caret-square-o-down"></span>
            </a>
        @endif
        <?php $counter = 0; ?>
        @foreach($allApps = getAvailableApps() as $app)
            @if(!Session::get('currentApp')->isEqual($app))
                @if($counter === 0)
                    <ul class="dropdown-menu">
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                @endif
                <li><!-- start message -->
                    <a href="{{action('HomeController@changeCurrentApp', [$app->id])}}">
                        <h4>
                            <span class="fa fa-mobile"></span> {{$app->name}}
                        </h4>
                    </a>
                </li><!-- end message -->
                <?php $counter++; ?>
            @endif
        @endforeach
        @if($counter > 0)
                </ul>
            </ul>
        @endif
    </div>
    <!-- Menu Toggle Button -->
</li>
