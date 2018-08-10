<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <strong>F</strong>R
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            | Food<strong>Rico</strong> |
        </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        {{ HTML::image('img/foodrico.png', 'User Image', array('class' => 'user-image')) }}

                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-ms">Welcome, {{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            {{ HTML::image('img/foodrico.png', 'User Image', array('class' => 'img-circle')) }}
                            <p>
                                {{ Auth::user()->name }}
                                <small>FoodRico {{ Auth::user()->group->name }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <button type="button" class="btn btn-default btn-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Sign Out') }}
                            </button>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
                </li>
            </ul>
        </div>
    </nav>
</header>