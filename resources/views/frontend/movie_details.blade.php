@push('style')

@endpush
@extends('layouts.frontend')
@section('content')
<!-- details -->
<section class="section section--details section--bg" loading="lazy" data-bg="{{asset('frontend')}}/img/section/details.jpg">
    <!-- details content -->
    <div class="container">
        <div class="row">
            <!-- title -->
            <div class="col-12">
                <h1 class="section__title section__title--mb">{{$movie->title}}</h1>
            </div>
            <!-- end title -->

            <!-- content -->
            <div class="col-12 col-xl-6">
                <div class="card card--details">
                    <div class="row">
                        <!-- card cover -->
                        <div class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-5">
                            <div class="card__cover">
                                <img src="{{asset('uploads')}}/cover/{{$movie->cover}}" alt="">
                                @if ($movie->rating)
                                <span class="card__rate card__rate--green">{{$movie->rating}}</span>
                                @endif
                                <span class="version_details card__rate--green">{{$movie->version}}</span>
                            </div>
                        </div>
                        <!-- end card cover -->

                        <!-- card content -->
                        <div class="col-12 col-md-8 col-lg-9 col-xl-7">
                            <div class="card__content">
                                <ul class="card__meta">
                                    <li><span style="font-size: 25px;">Movie/Series Info:</span></li>
                                    <li><span>Director:</span> {{$movie->director}}</li>
                                    <li><span>Genre:</span>
                                    @foreach (App\Models\InventoryModel::where('movie_id',$movie->id)->get() as $category )
                                    <a href="{{route('category.view',$category->category)}}">{{$category->category}}</a>
                                    @endforeach
                                    </li>
                                    <li><span>Release year:</span> {{$movie->release_year}}</li>
                                    <li><span>Running time:</span>{{$movie->running_time}}</li>
                                    <li><span>Language:</span>{{$movie->language}}</li>
                                    <li><span>Industry:</span> <a href="{{route('category.view',$movie->industry)}}">{{$movie->industry}}</a></li>
                                    <li><span>Country:</span> {{$movie->country}}</li>
                                </ul>

                            </div>
                        </div>
                        <!-- end card content -->
                    </div>
                </div>
            </div>
            <!-- end content -->



            </div>
            <!-- end player -->

        </div>
    </div>
    <!-- end details content -->
</section>
<!-- end details -->

<!-- content -->
<section class="content">
    <!-- <div class="content__head">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <h2 class="content__title">Google Ads Here</h2>

                </div>
            </div>
        </div>
    </div> -->

    <div class="container ">
        <div class="row mt-5">
            <div class="col-12 col-lg-8 col-xl-8">
                <!-- content tabs -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="1-tab">
                        <div class="row">

                            <div class="col-12">
                                <!-- content title -->
                                <h3 class=" color_primary">How To Download [ <i class="fa-solid fa-arrow-down fa-bounce"></i> ]</h3>
                                <p class="text_white">Please Scroll down, download links of different quality are given below.</p>
                                <p class="text_white"><span class="color_primary fs_1 fw_2 " >Description:</span><br>
                                    {{$movie->desp}}
                                </p>
                                <p><span class="color_primary fs_1 fw_2 " >Storyline:</span><br>
                                    <span class="text_white">{{$movie->story_line}}</span></p>

                                <h3><span class="color_primary">Screenshots:</span> (Must See Before Downloading)…</h3>
                                <!-- end content title -->
                            </div>

                            <!-- project gallery -->
                        <div class="gallery" itemscope>
                            <div class="row row--grid">

                                @foreach (App\Models\ScreenshortModel::where('movie_id', $movie->id)->get() as $ss )
                                    <!-- gallery item -->
                                <figure class="col-6 col-sm-6 col-xl-6" itemprop="associatedMedia" itemscope>
                                    <a href="{{asset('uploads')}}/screen_short/{{$ss->screen_short}}" itemprop="contentUrl" data-size="1920x1280">
                                        <img loading="lazy" src="{{asset('uploads')}}/screen_short/{{$ss->screen_short}}" itemprop="thumbnail" alt="Image description" />
                                    </a>
                                    <figcaption itemprop="caption description">Some image caption 1</figcaption>
                                </figure>
                                <!-- end gallery item -->
                                @endforeach


                            </div>
                        </div>
                        <!-- end project gallery -->


                        @foreach ($downLinks as $downLink )

                        <div class="col-12 mb_5">
                            <!-- content title -->
                            <h3 class="text_center mt_1"><span class="color_dark btn bg_primary"><a href="{{route('download',$downLink->id)}}" target="_blank" class="color_light fw_1">{{$downLink->caption}} &nbsp; <i class="fa-solid fa-download fa-beat"></i> </a></span></h3>
                            <!-- end content title -->
                        </div>

                        @endforeach



                        </div>
                    </div>
                </div>
                <!-- end content tabs -->
            </div>
            <!-- sidebar -->
            <div class="col-12 col-lg-4 col-xl-4 mb_4">
                <div class="row row--grid mt_4">
                    <!-- section title -->
                    <div class="col-12">
                        <h2 class="section__title section__title--sidebar">You may also like...</h2>
                    </div>
                    <!-- end section title -->

                    @foreach ($mayLikes as $mayLike )

                    <!-- card -->
                    <div class="col-4 col-sm-4 col-lg-4">
                        <a href="{{route('movie.details',$mayLike->url)}}">
                            <div class="card">
                                <div class="card__cover">
                                    <img loading="lazy" src="{{asset('uploads')}}/cover/{{$mayLike->cover}}" alt="">
                                    <a href="{{route('movie.details',$mayLike->url)}}" class="card__play">
                                        <i class="icon ion-ios-play"></i>
                                    </a>
                                    @if ($mayLike->rating)
                                    <span class=" card_recent card__rate--green">{{$mayLike->rating}}</span>
                                    @endif
                                    <span class="version_recent card__rate--green">{{$mayLike->version}}</span>
                                </div>
                                <div class="card__content">
                                    <h3 class="card__title"><a href="{{route('movie.details',$mayLike->url)}}">{{$mayLike->title}}</a></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- end card -->
                    @endforeach



                </div>

                <div class="row row--grid">
                    <!-- section title -->
                    <div class="col-12 mt_4">
                        <h2 class="section__title section__title--sidebar">Recent Posts...</h2>
                    </div>
                    <!-- end section title -->

                    @foreach ($recentMovie as $recent )

                    <!-- card -->
                    <div class="col-4 col-sm-4 col-lg-4">
                        <a href="{{route('movie.details',$recent->url)}}">
                            <div class="card">
                                <div class="card__cover">
                                    <img loading="lazy" src="{{asset('uploads')}}/cover/{{$recent->cover}}" alt="">
                                    <a href="{{route('movie.details',$recent->url)}}" class="card__play">
                                        <i class="icon ion-ios-play"></i>
                                    </a>
                                    @if ($recent->rating)
                                    <span class="card_recent card__rate--green">{{$recent->rating}}</span>
                                    @endif

                                    <span class="version_recent card__rate--green">{{$recent->version}}</span>

                                </div>
                                <div class="card__content">
                                    <h3 class="card__title"><a href="{{route('movie.details',$recent->url)}}">{{$recent->title}}</a></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- end card -->

                    @endforeach

                </div>
            </div>
            <!-- end sidebar -->


            <div class="col-lg-12 mb_4">
                    <div class="content__head">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <!-- content title -->
                                    <h2 class="content__title">Comments</h2>
                                    <!-- end content title -->

                                    <!-- content tabs nav -->
                                    <ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Say Somthing</a>
                                        </li>
                                    </ul>
                                    <!-- end content tabs nav -->

                                    <!-- content mobile tabs nav -->
                                    <div class="content__mobile-tabs" id="content__mobile-tabs">
                                        <div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <input type="button" value="Comments">
                                            <span></span>
                                        </div>

                                        <div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Comments</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- end content mobile tabs nav -->
                                </div>
                            </div>
                        </div>
                    </div>

                    @livewire('comment', [
                        'movie'=>$movie
                    ])


                </div>

        </div>
    </div>


</section>
<!-- end content -->
@include('frontend.share_icon')

@endsection


@push('element')
    <!-- Root element of PhotoSwipe. Must have class pswp. -->
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

		<!-- Background of PhotoSwipe.
		It's a separate element, as animating opacity is faster than rgba(). -->
		<div class="pswp__bg"></div>

		<!-- Slides wrapper with overflow:hidden. -->
		<div class="pswp__scroll-wrap">

			<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
			<!-- don't modify these 3 pswp__item elements, data is added later on. -->
			<div class="pswp__container">
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>

			<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
			<div class="pswp__ui pswp__ui--hidden">

				<div class="pswp__top-bar">

					<!--  Controls are self-explanatory. Order can be changed. -->

					<div class="pswp__counter"></div>

					<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

					<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

					<!-- Preloader -->
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
							<div class="pswp__preloader__cut">
								<div class="pswp__preloader__donut"></div>
							</div>
						</div>
					</div>
				</div>

				<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>

				<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
	</div>
@endpush

