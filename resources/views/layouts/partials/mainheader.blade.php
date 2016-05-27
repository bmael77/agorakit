<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>M</b>ZT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{Config::get('mobilizator.name')}}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('messages.toggle_navigation') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li>
                    <a href="{{ action('DashboardController@agenda') }}">
                        {{trans('group.latest_actions')}}
                    </a>
                </li>

                @if (Auth::check())
                    <li>
                        <a href="{{ action('DashboardController@unreadDiscussions') }}">
                            {{ trans('messages.latest_discussions') }}
                            @if ($unread_discussions > 0) <span class="badge">{{$unread_discussions}}</span>@endif
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ trans('messages.your_groups') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @forelse ($user_groups as $user_group)
                                    <li><a href="{{ action('GroupController@show', $user_group->id)}}">{{$user_group->name}}</a></li>
                                @empty
                                    <li><a href="{{ action('DashboardController@index')}}">{{ trans('membership.not_subscribed_to_group_yet') }}</a></li>
                                @endforelse
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ action('GroupController@create') }}">
                                    <i class="fa fa-bolt"></i> {{ trans('group.create_a_group_button') }}</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ action('DashboardController@users') }}">
                                {{trans('messages.users_list')}}
                            </a>
                        </li>
                    @endif


                    @if ($user_logged)

                        <form class="navbar-form navbar-left" role="search" action="{{url('search')}}">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="{{trans('messages.search')}}...">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </span>
                            </div><!-- /input-group -->
                        </form>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="avatar"><img src="{{Auth::user()->avatar()}}" class="img-circle" style="width:24px; height:24px"/></span> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{action('UserController@show', $user->id)}}"><i class="fa fa-btn fa-user"></i> {{ trans('messages.profile') }}</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('messages.logout') }}</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('register') }}">{{ trans('messages.register') }}</a></li>
                        <li><a href="{{ url('login') }}">{{ trans('messages.login') }}</a></li>
                    @endif

                    @if(\Config::has('app.locales'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ strtoupper(app()->getLocale()) }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(\Config::get('app.locales') as $lang => $locale)
                                    @if($lang !== app()->getLocale())
                                        <li>
                                            <a href="<?= count($_GET) ? '?'.http_build_query(array_merge($_GET, ['force_locale' => $lang])) : '?force_locale='.$lang ?>">
                                                <?= strtoupper($lang); ?>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif


                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">{{ trans('adminlte_lang::message.tasks') }}</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                {{ trans('adminlte_lang::message.tasks') }}
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% {{ trans('adminlte_lang::message.complete') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">{{ trans('adminlte_lang::message.alltasks') }}</a>
                            </li>
                        </ul>
                    </li>
                    @if (Auth::guest())
                        <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                    @else
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{asset('/img/user2-160x160.jpg')}}" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{ Auth::user()->name }}
                                        <small>{{ trans('adminlte_lang::message.login') }} Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">{{ trans('adminlte_lang::message.followers') }}</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">{{ trans('adminlte_lang::message.sales') }}</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">{{ trans('adminlte_lang::message.friends') }}</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.signout') }}</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
