<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="{{asset('backend')}}/" data-template="vertical-menu-template">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    {{-- Title Dynamic Code --}}
    @php

        $url = $_SERVER['REQUEST_URI'];
        $explode = explode('/', $url);
        $title = $explode[1];
        $page_title = ucwords($explode[1]);

        if ($title == 'dashboard') {
            $page_title = 'Dashboard';
        }
        elseif ($title == 'category') {
            $page_title = 'Category';
        }

        elseif ($title == 'movie_add') {
            $page_title = 'Add Movie';
        }
        elseif ($title == 'movie_list') {
            $page_title = 'Movies List';
        }
        elseif ($title == 'movie_edit') {
            $page_title = 'Movie Edit';
        }
        elseif ($title == 'features') {
            $page_title = 'Features';
        }
        elseif ($title == 'message') {
            $page_title = 'Message';
        }
        elseif ($title == 'configMeta') {
            $page_title = 'Meta Config';
        }
        elseif ($title == 'users') {
            $page_title = 'Users';
        }
    @endphp
    {{-- Title Dynamic Code End --}}

    <title>{{$page_title}} | CineNest – Online Movies Website </title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/logo/favicon.png') }}" />

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap"
        rel="stylesheet">

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/css/demo.css" />
	<link rel="stylesheet" href="{{asset('backend')}}/css/custom.css">


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet"
        href="{{ asset('backend') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
    <link rel="stylesheet"
        href="{{ asset('backend') }}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/libs/select2/select2.css" />

    <link rel="stylesheet" href="{{ asset('backend') }}/richtexteditor/rte_theme_default.css" />


    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/css/pages/cards-advance.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/css/pages/app-email.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/css/pages/page-account-settings.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/vendor/css/pages/page-profile.css" />






    <!-- Helpers -->
    <script src="{{ asset('backend') }}/vendor/js/helpers.js"></script>
    <script src="{{ asset('backend') }}/js/config.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"/>


    {{-- Text Editor Customize Code --}}
    <style>
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        span,
        p {
            padding: 0;
            margin: 0;
        }

        hr {
            margin: 0;
        }

        .swal2-popup {
            top: 10%;
        }

        .dt-buttons {
            display: none;
        }

        .app-brand-logo img {
            width: 180px;
            margin-left: 8px;
        }

        .user-profile-header .user-profile-img {
            border: 5px solid transparent;
        }


        .table th {
        font-weight: 600;
        }
        .dt-length label{
            display:none;
        }
    </style>
    @stack('style')

</head>

<body>


  <!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">
<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">


    <div class="app-brand demo">
        <a href="{{route('dashboard')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('backend/logo/logo.png') }}" alt="logo" />
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

  <div class="menu-inner-shadow"></div>



  <ul class="menu-inner py-1">
    @if (Auth::user()->roll == 'admin')
    <!-- Dashboards -->
    <li class="menu-item {{$title == 'dashboard'?'active':''}}">
        <a href="{{route('dashboard')}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-align-box-bottom-center"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    @endif

    @if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator')
        <!-- Layouts -->
    <li class="menu-item {{$title == 'category'?'active':''}}">
        <a href="{{route('category')}}" class="menu-link">
            <i class="fa-solid fa-table-cells fa-lg me-2"></i>
          <div data-i18n="Category">Category</div>
        </a>
      </li>
    @endif

      <!-- Movies -->
    <li class="menu-item
        {{$url == '/movie_add'?'open':''}}
        {{$url == '/movie_list'?'open':''}}
        {{$title == 'movie_edit'?'open':''}}
    ">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="fa-solid fa-film fa-lg me-2"></i>
        <div data-i18n="Movies">Movies</div>
      </a>

      <ul class="menu-sub">

        @if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator')
            <li class="menu-item {{$title == 'movie_add'?'active':''}}">
                <a href="{{route('movie.add')}}" class="menu-link">
                <div data-i18n="Add Movie">Add Movie</div>
                </a>
            </li>
        @endif

        <li class="menu-item
        {{$url == '/movie_list'?'active':''}}
        {{$title == 'movie_edit'?'active':''}}
        ">
          <a href="{{route('movie.list')}}" class="menu-link">
            <div data-i18n="Movie List">Movie List</div>
          </a>
        </li>

      </ul>
    </li>

    @if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator')
          <!-- Features -->
    <li class="menu-item {{$title == 'features'?'active':''}}">
        <a href="{{route('features')}}" class="menu-link">
            <i class="fa-solid fa-chart-pie fa-lg me-2"></i>
          <div data-i18n="Features">Features</div>
        </a>
    </li>
    @endif

    @if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator')
        <!-- Messages -->
        <li class="menu-item {{$title == 'message'?'active':''}}">
            <a href="{{route('message')}}" class="menu-link">
              <i class="menu-icon tf-icons ti ti-mail"></i>
              <div data-i18n="Message">Message</div>
            </a>
        </li>
        <!-- Messages -->
        <li class="menu-item {{$title == 'comments'?'active':''}}">
            <a href="{{route('comments')}}" class="menu-link">
              <i class="menu-icon tf-icons ti ti-mail"></i>
              <div data-i18n="Comments">Comments</div>
            </a>
        </li>
    @endif

    @if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'marketer')
    <!-- Meta Config -->
    <li class="menu-item {{$title == 'configMeta'?'active':''}}">
        <a href="{{route('configMeta')}}" class="menu-link">
            <i class="fa-solid fa-hammer fa-lg me-2"></i>
          <div data-i18n="Meta Config">Meta Config</div>
        </a>
    </li>
    @endif

    @if (Auth::user()->roll == 'admin')
            <!-- Users -->
    <li class="menu-item {{$title == 'users'?'active':''}}">
        <a href="{{route('users')}}" class="menu-link">
            <i class="fa-solid fa-users fa-lg me-2"></i>
          <div data-i18n="Users">Users</div>
        </a>
    </li>
    @endif

    @if (Auth::user()->roll == 'admin')
            <!-- Users -->
    <li class="menu-item {{$title == 'activityLog'?'active':''}}">
        <a href="{{route('activityLog')}}" class="menu-link">
            <i class="fa-solid fa-chart-line fa-lg me-2"></i>
          <div data-i18n="Activity Log">Activity Log</div>
        </a>
    </li>
    @endif



    <!-- Payout -->
    <li class="menu-item {{$title == 'payout'?'active':''}}">
        <a href="{{route('payout')}}" class="menu-link">
            <i class="fa-solid fa-dollar-sign px-1"></i>
            <div data-i18n="Payout">Payout</div>
        </a>
    </li>

    @if (Auth::user()->roll == 'admin')
    <!-- Payment -->
    <li class="menu-item {{$title == 'payment'?'active':''}}">
        <a href="{{route('payment')}}" class="menu-link">
            <i class="fa-solid fa-hand-holding-dollar px-1"></i>
            <div data-i18n="Payment">Payment</div>
        </a>
    </li>
    @endif

  </ul>



</aside>
<!-- / Menu -->



    <!-- Layout container -->
    <div class="layout-page">

        <!-- Top Navbar Start -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="ti ti-menu-2 ti-sm"></i>
                </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <ul class="navbar-nav flex-row align-items-center ms-auto">


                    <!-- Points -->
                    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                        <p class="nav-link dropdown-toggle hide-arrow doller" href="javascript:void(0);"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <i class="fa-solid fa-cent-sign px-1"></i>
                            {{ App\Models\PaymentInfoModel::where('user_id', Auth::user()->id)->first()->point ?? 0 }}
                        </p>
                    </li>
                    <!--/ Points -->

                    <!-- Message -->
                    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                        @if (Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator')
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="ti ti-mail ti-md"></i>
                        <span class="badge bg-danger rounded-pill badge-notifications">{{App\Models\ContactMessageModel::where('status','0')->count()}}</span>
                    </a>
                        @endif
                        <ul class="dropdown-menu dropdown-menu-end py-0">
                            <li class="dropdown-menu-header border-bottom">
                                <div class="dropdown-header d-flex align-items-center py-3">
                                    <h5 class="text-body mb-0 me-auto">Messages</h5>

                                </div>
                            </li>
                            <li class="dropdown-notifications-list scrollable-container">
                                <ul class="list-group list-group-flush">

                                    @forelse (App\Models\ContactMessageModel::where('status','0')->latest()->get() as $message )

                                    <a href="{{route('message.read',$message->id)}}" class="d-flex">
                                        <li
                                            class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 mx-4">
                                                    <h6 class="mb-1">{{ $message->name}}   </h6>
                                                    <p class="mb-0">{{ $message->subject }}</p>
                                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                    @empty

                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <span>No new message found!</span>
                                    </li>

                                    @endforelse




                                </ul>
                            </li>
                            <li class="dropdown-menu-footer border-top">
                                <a href="{{route('message')}}"
                                    class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                                    View all Messages
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--/ Message -->

                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <div class="avatar">



                                @if (Auth::user()->photo == null)
                                    <img src="{{ asset('backend') }}/img/avatars/9.png" alt="profile photo" class="h-auto rounded-circle">
                                @else
                                    <img src="{{ asset('uploads') }}/profile/{{Auth::user()->photo}}" alt class="h-auto rounded-circle">
                                @endif


                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{route('profile')}}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                @if (Auth::user()->photo == null)
                                                <img src="{{ asset('backend') }}/img/avatars/9.png" alt="profile photo" class="h-auto rounded-circle">
                                            @else
                                                <img src="{{ asset('uploads') }}/profile/{{Auth::user()->photo}}" alt class="h-auto rounded-circle">
                                            @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                            <small
                                                class="text-muted text-capitalize">{{ Auth::user()->roll }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('profile')}}">
                                    <i class="ti ti-user-check me-2 ti-sm"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('profile.setting')}}">
                                    <i class="ti ti-settings me-2 ti-sm"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" target="_blank"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        <i class="ti ti-logout me-2 ti-sm"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </form>
                            </li>

                        </ul>
                    </li>
                    <!--/ User -->

                </ul>
            </div>

        </nav>
        <!-- Top Navbar End -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <!-- Content -->
                @yield('content')
                <!-- / Content -->
            </div>

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <hr>
                <div class="container-xxl">
                    <div class="footer-container text-center py-2">
                        <div>
                            &copy; CineNest</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
    </div>



    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>


    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

  </div>
  <!-- / Layout wrapper -->


  <!-- JS -->

  <script src="{{asset('backend')}}/vendor/libs/jquery/jquery.js"></script>
  <script src="{{asset('backend')}}/vendor/libs/popper/popper.js"></script>
  <script src="{{asset('backend')}}/vendor/js/bootstrap.js"></script>
  <script src="{{asset('backend')}}/vendor/libs/node-waves/node-waves.js"></script>
  <script src="{{asset('backend')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="{{asset('backend')}}/vendor/libs/hammer/hammer.js"></script>
  <script src="{{asset('backend')}}/vendor/libs/i18n/i18n.js"></script>
  <script src="{{asset('backend')}}/vendor/libs/typeahead-js/typeahead.js"></script>
   <script src="{{asset('backend')}}/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{asset('backend')}}/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{asset('backend')}}/vendor/libs/swiper/swiper.js"></script>

  <!-- Main JS -->
  <script src="{{asset('backend')}}/js/main.js"></script>


  <!-- Page JS -->
  <script src="{{asset('backend')}}/js/dashboards-analytics.js"></script>

  {{-- Sweet Alart --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  /* Data Table */
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
  <script>
        new DataTable('#example', {
        layout: {
            bottomEnd: {
                paging: {
                    boundaryNumbers: false
                }
            }
        }
        });
    </script>
        <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        ></script>



  @stack('script')

</body>

</html>



