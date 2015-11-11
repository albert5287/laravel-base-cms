<li class="dropdown navbar-nav">
    <div class="btn-user-switch messages-menu">
        <a href="#" aria-expanded="false" class="no-padding-right">
            <span class="hidden-xs">{{Auth::user()->name}}</span>
        </a>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="fa fa-fw fa-caret-square-o-down"></span>
        </a>
        @foreach($allUsers = getAvailableUsers() as $index => $user)
            @if($index === 0)
                <ul class="dropdown-menu">
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
            @endif
                            <li><!-- start message -->
                                <a href="{{action('HomeController@changeUser', [$user])}}">
                                    <h4>
                                        <span class="fa fa-user"></span> {{$user->name}}
                                    </h4>
                                </a>
                            </li><!-- end message -->
                            @endforeach
                            @if(sizeof($allUsers) > 0)
                        </ul>
                    </li>
                </ul>
            @endif
    </div>
    <!-- Menu Toggle Button -->
</li>
<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="{{url('logout')}}">
        <!-- The user image in the navbar-->
        <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>-->
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">logout</span>
    </a>
</li>