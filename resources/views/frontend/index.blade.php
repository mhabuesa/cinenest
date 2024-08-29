@push('style')

@endpush
@extends('layouts.frontend')
@section('content')
    <!-- home -->
	<section class="home">
		{{-- <!-- home bg -->
		<div class="owl-carousel home__bg">
            @foreach ($supperHits as $supperHit )
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

                        @foreach ($supperHits as $supperHit )

						<div class="card card--big">
							<div class="card__cover">
								<img src="{{asset('uploads')}}/cover/{{$supperHit->cover}}" alt="">
								<a href="{{route('movie.details',$supperHit->url)}}" class="card__play">
									<i class="icon ion-ios-play"></i>
								</a>
                                @if ($supperHit->rating)
                                <span class="card__rate card__rate--{{$supperHit->rating >= 7 ? 'green' : ($supperHit->rating >= 5 ? 'yellow' : 'red')}}">{{$supperHit->rating}}</span>
                                @endif
                                @if ($supperHit->version)
                                <span class="version_head card__rate--green">{{$supperHit->version}}</span>
                                @endif


                                @auth('visitor')
                                <a href="{{route('favorite.toggle',$supperHit->id)}}" class="item__favorite {{ App\Models\FavoriteModel::where('movie_id', $supperHit->id)->where('visitor_id', Auth::guard('visitor')->user()->id)->first() ? 'favorite_active' : '' }}" >
                                    <i class="fa-duotone fa-bookmark"></i>
                                </a>
                                @else
                                <a href="{{route('signin')}}" class="item__favorite"><i class="fa-duotone fa-bookmark"></i></a>
                                @endauth
							</div>
							<div class="card__content">
								<h3 class="card__title"><a href="{{route('movie.details',$supperHit->url)}}">{{$supperHit->title}}</a></h3>

							</div>
						</div>
                        @endforeach


					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end home -->

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
							<a href="{{route('oscar')}}" class="section__view">View All</a>

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

                        @foreach ($oscars as $oscar )

                        <div class="card">
							<a href="{{route('movie.details',$oscar->url)}}">
                                <div class="card__cover">
                                    <img src="{{asset('uploads')}}/cover/{{$oscar->cover}}" alt="">
                                    <a href="{{route('movie.details',$oscar->url)}}" class="card__play">
                                        <i class="icon ion-ios-play"></i>
                                    </a>
                                    @if ($oscar->rating)
                                    <span class="card__rate card__rate--{{$oscar->rating >= 7 ? 'green' : ($oscar->rating >= 5 ? 'yellow' : 'red')}}">{{$oscar->rating}}</span>
                                    @endif
                                    @if ($oscar->version)
                                    <span class="version card__rate--green">{{$oscar->version}}</span>
                                    @endif


                                    @auth('visitor')
                                    <a href="{{route('favorite.toggle',$oscar->id)}}" class="item__favorite {{ App\Models\FavoriteModel::where('movie_id', $oscar->id)->where('visitor_id', Auth::guard('visitor')->user()->id)->first() ? 'favorite_active' : '' }}" >
                                        <i class="fa-duotone fa-bookmark"></i>
                                    </a>
                                    @else
                                    <a href="{{route('signin')}}" class="item__favorite"><i class="fa-duotone fa-bookmark"></i></a>
                                    @endauth

                                </div>
                            </a>
							<div class="card__content">
								<h3 class="card__title"><a href="{{route('movie.details',$oscar->url)}}">{{$oscar->title}}</a></h3>
								<span class="card__category">
                                    @foreach (App\Models\InventoryModel::where('movie_id', $oscar->id )->get() as $category )
                                    <a href="{{route('category.view',$category->slug)}}">{{$category->category}}</a>
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
<!-- Include jQuery if not already included -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.item__favorite').on('click', function(e) {
            e.preventDefault();

            var $this = $(this);  // Cache the clicked element
            var movieId = $this.data('id');
            var url = "{{ route('favorite.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    movie_id: movieId
                },
                success: function(response) {
                    if(response.success) {
                        // Toggle the .favorite_active class based on the server's response
                        if(response.status === 'added') {
                            $this.addClass('favorite_active');
                        } else if(response.status === 'removed') {
                            $this.removeClass('favorite_active');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script> --}}
@endpush
