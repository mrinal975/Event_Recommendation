<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a href="/" class="navbar-brand">Event Recomender System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="form-inline ml-auto">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <router-link class="nav-link" to="/">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/schedule" class="nav-link" >Schedule</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/dailyschedule" class="nav-link" >DailySchedule</router-link>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span><i class="fas fa-user"></i></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link to="/profile/{{auth()->user()->id}}" class="dropdown-item" >Profile</router-link>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                           Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    <br>
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>

</div>
@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth
<script src="js/app.js"></script>
<script src="js/custom.js"></script>
</body>
</html>