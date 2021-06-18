<!DOCTYPE HTML>
<html>

<head>
    <title>@yield('pageTitle')</title>
    <meta charset="utf-8" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="{{asset("css/home.css")}}"/>
<body style="max-width:1200px;margin:0 auto;min-width:1200px">
<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div id="top-header">
            <div class="container">
                <ul class="header-links">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a style="color:black;" class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="navigation">
        <div class="wrapper">
        <div class="header-logo">
            <h1 style="margin-top:15px;"><a style="color:Black;" href="{{ url('/home') }}">Home</a></h1>
            <h1 style="margin-top:15px;"><a style="color:Black;" href="{{ url('/favoriet') }}">Favorites</a></h1>
        </div>
        <form class="choice">
            <select name="keuze" onchange="toggle(this.value)">
                <option selected="true" disabled="disabled">Opties Zoeken</option>
                <option value="1">Zoeken op titel</option>
                <option value="2">Zoeken op category</option>
                <option value="3">Zoeken op Datum</option>
            </select>
        </form>
        <form style="display:none" id="categorie" method="get" action="{{ url ('categorie')}}" >
            <select name="category">
            @foreach(App\Post::select('category')->distinct()->get() as $category)
                <option value='{{ $category->category}}'>{{ $category->category }}</option>
            @endforeach
            </select>
            <button type="submit" name="search">Search Category</button>
        </form>
        <form style="display:none" id="title" method="post" action="{{ url ('search/')}}" >
            @csrf
            <div class="qty-label">
                <div class="input-number">
                    <input type="text" name="searchterm">
                    <button type="submit" name="search">Search</button>
                </div>
            </div>

        </form>
        <form style="display:none" id="date" method="post" action="{{ url ('searchdate/')}}" >
            @csrf
            <div class="qty-label">
                <div class="input-number">
                    <input type="date" name="dateterm">
                    <button type="submit" name="date">Search</button>
                </div>
            </div>

        </form>
        </div>
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->



<!-- Main -->
<div class="wrapper">
    @include('flash-message')
    @yield('pageContent')
</div>

<div id="footer">
    <div class="wrapper">
        <p class="l">2020 - Bennert Depuydt</p>
        <p class="r">Template by: Laravel</p>
    </div>
</div>
<!-- /FOOTER -->

<!-- jQuery Plugins -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/nouislider.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>
<script src="js/main.js"></script>
<script>
    function toggle(value) {
        if(value == "1"){
            var cat = document.getElementById('categorie');
            var title = document.getElementById('title');
            var date = document.getElementById('date');
            date.style.display = 'none';
            title.style.display = 'block';
            cat.style.display = 'none';
        }
        else if(value== "2"){
            var cat = document.getElementById('categorie');
            var title = document.getElementById('title');
            var date = document.getElementById('date');
            date.style.display = 'none';
            cat.style.display = 'block';
            title.style.display = 'none';
        }
        else {
            var cat = document.getElementById('categorie');
            var title = document.getElementById('title');
            var date = document.getElementById('date');
            date.style.display = 'block';
            cat.style.display = 'none';
            title.style.display = 'none';
        }

    }
</script>
</body>
</html>
