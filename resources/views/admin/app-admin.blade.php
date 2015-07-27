<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CometCMS App</title>
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300|Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('/css/app-admin.css') }}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-admin navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{-- <a class="navbar-brand" href="{{ url('/admin') }}">Dashboard</a> --}}
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/admin') }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ url('/admin/teams') }}">Squad management</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Content <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="disabled"><a href="{{ url('/admin/pages') }}">Pages</a></li>
                        <li class="disabled"><a href="{{ url('/admin/posts') }}">Posts</a></li>
                        <li><a href="{{ url('/admin/games') }}">Games</a></li>
                        <li><a href="{{ url('/admin/opponents') }}">Opponents</a></li>
                        <li><a href="{{ url('/admin/matches') }}">Matches</a></li>
                        <li class="disabled"><a href="{{ url('/admin/events') }}">Events</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Site <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="disabled"><a href="{{ url('/admin/settings') }}">Settings</a></li>
                        <li class="disabled"><a href="{{ url('/admin/navigation') }}">Navigation</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users management <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/users') }}">Users</a></li>
                        <li><a href="{{ url('/admin/roles') }}">User roles</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                {{-- <li><a href="#"><i class="fa fa-fw fa-bell"></i> <span class="badge">42</span></a></li> --}}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/') }}">View site</a></li>
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include('admin.partials.pagebar')

@include('admin.partials.alerts')

@yield('content')

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<script src="//cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.min.js"></script>
@yield('page-scripts-before')
<script src="{{ asset('/js/dependencies.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>
@yield('page-scripts')
</body>
</html>
