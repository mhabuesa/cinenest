@php
    $configMeta = App\Models\ConfigMetaModel::find(1);
    $explode = explode('/', $_SERVER['REQUEST_URI']);
    $title = $explode[1];
    $title = ucwords($explode[1]);

    if ($explode[1] == '') {
        $title = 'Home';
    } elseif ($explode[1] == 'cat') {
        $slug = $explode[2];
        $title = App\Models\CategoryModel::where('slug', $slug)->first()->category;
    } elseif ($explode[1] == 'contact') {
        $title = 'Contact';
    } elseif ($explode[1] == 'mvi') {
        $url = $explode[2];
        $title = App\Models\MovieModel::where('url', $url)->first()->title;
    }

    if ($explode[1] == 'mvi') {
        $url = $explode[2];
        $pageMeta = App\Models\MovieModel::where('url', $url)->first();
        $configMetaImage = $pageMeta->cover;
    } else {
        $pageMeta = App\Models\ConfigMetaModel::find(1);
        $configMetaImage = App\Models\ConfigMetaModel::find(1)->image;
    }

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Meta Elements -->
    {{-- Config Meta  --}}
    <meta name="owner" content="{{ $configMeta->owner }}" />
    <meta name="type" content="{{ $configMeta->type }}" />
    <meta name="url" content="{{ url()->full() }}" />
    <meta name="site_name" content="{{ $configMeta->site_name }}" />
    <meta name="google-site-verification" content="{{ $configMeta->verify }}" />
    @if ($explode[1] == 'mvi')
        <meta property="og:image" content="{{ asset('uploads') }}/cover/{{ $configMetaImage }}" />
    @else
        <meta property="og:image" content="{{ asset('uploads') }}/metaConfig/{{ $configMetaImage }}" />
    @endif
    <meta property="og:type" content="{{ $configMeta->type }}" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:site_name" content="{{ $configMeta->site_name }}" />

    {{-- Page Meta  --}}
    <meta name="title" content="{{ $pageMeta->title }}" />
    <meta name="description" content="{{ $pageMeta->desp }}" />
    <meta name="keywords" content="{{ $pageMeta->keyword }}" />
    <meta property="og:title" content="{{ $pageMeta->title }}" />
    <meta property="og:description" content="{{ $pageMeta->desp }}" />
    <!-- Meta Elements End -->

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/plyr.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/photoswipe.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/default-skin.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/custom.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/icon/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('frontend') }}/icon/favicon.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>{{ $title }} | CineNest – Online Movies, TV Shows & Cinema Website</title>

    {{-- fontawesome --}}
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-d53d10572a0e0d37cb8d614a3f177a0c.css?vsn=d">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-light.css">
    @stack('head')

</head>

<body class="body">
    <!-- header -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__content">
                        <!-- header logo -->
                        <a href="{{ route('index') }}" class="header__logo">
                            <img src="{{ asset('frontend') }}/img/logo.png" alt="">
                        </a>
                        <!-- end header logo -->

                        <!-- header nav -->
                        <ul class="header__nav">
                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="{{ route('index') }}">Home</a>
                            </li>
                            <!-- end dropdown -->

                            <!-- dropdown -->
                            <li class="dropdown header__nav-item">
                                <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#"
                                    role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Category<i class="icon ion-ios-arrow-down"></i></a>
                                <div class="dropdown-menu header__dropdown-menu scrollbar-dropdown"
                                    aria-labelledby="dropdownMenuMore">
                                    @foreach (App\Models\CategoryModel::all() as $category)
                                        <a
                                            href="{{ route('category.view', $category->slug) }}">{{ $category->category }}</a>
                                    @endforeach

                                </div>
                            </li>
                            <!-- end dropdown -->

                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="{{ route('contact') }}">Contact</a>
                            </li>
                            <!-- end dropdown -->

                        </ul>
                        <!-- end header nav -->

                        <!-- header auth -->
                        <div class="header__auth">
                            <form action="{{ route('search') }}" method="GET" class="header__search">
                                <input class="header__search-input" id="search_input" name="key" type="text"
                                    placeholder="Search...">
                                <button class="header__search-button search_btn" type="submit"><i
                                        class="icon ion-ios-search"></i></button>
                                <button class="header__search-close" type="button"><i
                                        class="icon ion-md-close"></i></button>
                            </form>

                            <button class="header__search-btn" type="button">
                                <i class="icon ion-ios-search"></i>
                            </button>

                            @auth('visitor')
                            <a href="{{route('user.profile')}}" class="header__sign-in">
                                <i class="icon ion-ios-person"></i>
								<span class="text_center">{{Auth::guard('visitor')->user()->name}}</span></a>
                            @else
                            <a href="{{route('signin')}}" class="header__sign-in">
								<i class="icon ion-ios-log-in"></i>
								<span>Sign In</span>
							</a>
                            @endauth





                        </div>
                        <!-- end header auth -->
                        <!-- header menu btn -->
                        <button class="header__btn" type="button">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <!-- end header menu btn -->


                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->

    @yield('content')

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer__content">
                        <a href="{{ route('index') }}" class="footer__logo">
                            <img src="{{ asset('frontend') }}/img/logo.png" alt="">
                        </a>

                        <span class="footer__copyright">© CINENEST, 2024 <br> Create by <span class="text-danger"> <a
                                    href="https://www.facebook.com/CineNest.net" target="_blank"
                                    title="CineNest">CINENEST TEAM</a></span></span>

                        <nav class="footer__nav">
                            <a href="{{ route('contact') }}">Contacts</a>
                            <a href="{{ route('disclaimer') }}">Disclaimer</a>
                            <a href="{{ route('privacyPolicy') }}">Privacy policy</a>
                        </nav>

                        <button class="footer__back" type="button">
                            <i class="icon ion-ios-arrow-round-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    @stack('element')

    <!-- JS -->
    <script src="{{ asset('frontend') }}/js/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('frontend') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('frontend') }}/js/jquery.magnific-popup.min.js"></script>

    <script src="{{ asset('frontend') }}/js/jquery.mousewheel.min.js"></script>

    <script src="{{ asset('frontend') }}/js/jquery.mCustomScrollbar.min.js"></script>

    <script src="{{ asset('frontend') }}/js/wNumb.js"></script>

    <script src="{{ asset('frontend') }}/js/nouislider.min.js"></script>

    <script src="{{ asset('frontend') }}/js/plyr.min.js"></script>
    <script src="{{ asset('frontend') }}/js/photoswipe.min.js"></script>
    <script src="{{ asset('frontend') }}/js/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('frontend') }}/js/main.js"></script>

    {{-- <script>
        $('.search_btn').click(function(){
            var search_input = $('#search_input').val();
            var link = "{{route('search')}}"+"?key="+search_input;
            window.location.href = link;
        });
    </script> --}}


    <!-- JS -->

</body>

</html>
