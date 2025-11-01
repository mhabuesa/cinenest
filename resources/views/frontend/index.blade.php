@push('title')
    <title>HOME | CineNest – Online Movies, TV Shows, Cinema Website</title>
@endpush
@push('page_meta')
    <meta name="title" content="{{ $pageMeta->title }}" />
    <meta name="description" content="{{ $pageMeta->desp }}" />
    <meta name="keywords" content="{{ $pageMeta->keyword }}" />
    <meta property="og:title" content="{{ $pageMeta->title }}" />
    <meta property="og:description" content="{{ $pageMeta->desp }}" />
    <meta property="og:image" content="{{ asset('uploads') }}/metaConfig/{{ $pageMeta->image }}" />

    {{-- <meta property="og:image" content="{{ asset('uploads') }}/cover/{{ $configMetaImage }}" /> --}}
@endpush
@extends('layouts.frontend')
@section('content')
    <!-- home -->
    <section class="home">
        {{-- <!-- home bg -->
		<div class="owl-carousel home__bg">
            @foreach ($supperHits as $supperHit)
            @php
                    $ss = App\Models\ScreenshortModel::where('movie_id', $supperHit->id)->first();
            @endphp
			<div class="item home__cover" data-bg="{{asset('uploads')}}/screen_short/{{$ss->screen_short}}"></div>
            @endforeach
		</div>
		<!-- end home bg --> --}}

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="home__title"><b>Best Movies</b> OF THIS SEASON</h1>

                    <button class="home__nav home__nav--prev" type="button">
                        <i class="icon ion-ios-arrow-round-back"></i>
                    </button>
                    <button class="home__nav home__nav--next" type="button">
                        <i class="icon ion-ios-arrow-round-forward"></i>
                    </button>
                </div>

                <div class="col-12">
                    <div class="owl-carousel home__carousel home__carousel--bg">

                        @foreach ($supperHits as $supperHit)
                            <div class="card card--big">
                                <div class="card__cover">
                                    <img src="{{ asset('uploads') }}/cover/{{ $supperHit->cover }}" alt="">
                                    <a href="{{ route('movie.details', $supperHit->url) }}" class="card__play">
                                        <i class="icon ion-ios-play"></i>
                                    </a>
                                    @if ($supperHit->rating)
                                        <span
                                            class="card__rate card__rate--{{ $supperHit->rating >= 7 ? 'green' : ($supperHit->rating >= 5 ? 'yellow' : 'red') }}">{{ $supperHit->rating }}</span>
                                    @endif
                                    @if ($supperHit->version)
                                        <span class="version_head card__rate--green">{{ $supperHit->version }}</span>
                                    @endif


                                    @auth('visitor')
                                        <a href="{{ route('favorite.toggle', $supperHit->id) }}"
                                            class="item__favorite {{ App\Models\FavoriteModel::where('movie_id', $supperHit->id)->where('visitor_id', Auth::guard('visitor')->user()->id)->first()? 'favorite_active': '' }}">
                                            <i class="fa-duotone fa-bookmark"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('signin') }}" class="item__favorite"><i
                                                class="fa-duotone fa-bookmark"></i></a>
                                    @endauth
                                </div>
                                <div class="card__content">
                                    <h3 class="card__title"><a
                                            href="{{ route('movie.details', $supperHit->url) }}">{{ $supperHit->title }}</a>
                                    </h3>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end home -->
        <div class="container my-4">
            <div class="row m-auto">
                <div class="col-12 ads_banner">

                    <div class="small_banner">
                        <a href="https://wa.me/8801680582787" target="_blank">
                            <img src="{{ asset('frontend/img/add_small.png') }}" alt="">
                        </a>
                    </div>

                    <div class="large_banner">
                        <a href="https://wa.me/8801680582787" target="_blank">
                            <img src="{{ asset('frontend/img/add_large.png') }}" alt="">
                        </a>
                    </div>

                </div>
            </div>
        </div>

    <!-- content -->
    <section class="content">
        <div class="content__head">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- content title -->
                        <h2 class="content__title fw_4">All Items</h2>
                        <!-- end content title -->
                    </div>
                </div>
            </div>
        </div>

        <!-- catalog -->
        <div class="container">

            @livewire('all-content')

        </div>
        <!-- end catalog -->
    </section>
    <!-- end content -->

    <!-- section -->
    <section class="section section--border">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-12">
                    <div class="section__title-wrap">
                        <h2 class="section__title">Oscar Winning Movies</h2>

                        <div class="section__nav-wrap">
                            <a href="{{ route('oscar') }}" class="section__view">View All</a>

                            <button class="section__nav section__nav--prev" type="button" data-nav="#carousel1">
                                <i class="icon ion-ios-arrow-back"></i>
                            </button>

                            <button class="section__nav section__nav--next" type="button" data-nav="#carousel1">
                                <i class="icon ion-ios-arrow-forward"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- end section title -->

                <!-- carousel -->
                <div class="col-12">
                    <div class="owl-carousel section__carousel" id="carousel1">

                        @foreach ($oscars as $oscar)
                            <div class="card">
                                <a href="{{ route('movie.details', $oscar->url) }}">
                                    <div class="card__cover">
                                        <img src="{{ asset('uploads') }}/cover/{{ $oscar->cover }}" alt="">
                                        <a href="{{ route('movie.details', $oscar->url) }}" class="card__play">
                                            <i class="icon ion-ios-play"></i>
                                        </a>
                                        @if ($oscar->rating)
                                            <span
                                                class="card__rate card__rate--{{ $oscar->rating >= 7 ? 'green' : ($oscar->rating >= 5 ? 'yellow' : 'red') }}">{{ $oscar->rating }}</span>
                                        @endif
                                        @if ($oscar->version)
                                            <span class="version card__rate--green">{{ $oscar->version }}</span>
                                        @endif


                                        @auth('visitor')
                                            <a href="{{ route('favorite.toggle', $oscar->id) }}"
                                                class="item__favorite {{ App\Models\FavoriteModel::where('movie_id', $oscar->id)->where('visitor_id', Auth::guard('visitor')->user()->id)->first()? 'favorite_active': '' }}">
                                                <i class="fa-duotone fa-bookmark"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('signin') }}" class="item__favorite"><i
                                                    class="fa-duotone fa-bookmark"></i></a>
                                        @endauth

                                    </div>
                                </a>
                                <div class="card__content">
                                    <h3 class="card__title"><a
                                            href="{{ route('movie.details', $oscar->url) }}">{{ $oscar->title }}</a></h3>
                                    <span class="card__category">
                                        @foreach (App\Models\InventoryModel::where('movie_id', $oscar->id)->get() as $category)
                                            <a
                                                href="{{ route('category.view', $category->slug) }}">{{ $category->category }}</a>
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <!-- carousel -->
            </div>
        </div>
    </section>
    <!-- end section -->
    @include('frontend.share_icon')
@endsection


@push('element')
@endpush
