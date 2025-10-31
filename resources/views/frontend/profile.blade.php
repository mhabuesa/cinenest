@push('title')
<title>Profile | CineNest – Online Movies, TV Shows, Cinema Website</title>
@endpush
@push('page_meta')
<meta name="title" content="{{ $pageMeta->title }}" />
<meta name="description" content="{{ $pageMeta->desp }}" />
<meta name="keywords" content="{{ $pageMeta->keyword }}" />
<meta property="og:title" content="{{ $pageMeta->title }}" />
<meta property="og:description" content="{{ $pageMeta->desp }}" />
<meta property="og:image" content="{{ asset('uploads') }}/metaConfig/{{ $pageMeta->image }}" />
@endpush
@extends('layouts.frontend')
@section('content')
    <!-- page title -->
	<section class="section section--first section--bg" data-bg="{{asset('frontend')}}/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">My Profile</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="{{route('index')}}">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Profile</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- content -->
	<div class="content content--profile">
		<!-- profile -->
		<div class="profile">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="profile__content">
							<div class="profile__user">
								<div class="profile__avatar">
									<img src="{{asset('frontend')}}/img/user.svg" alt="">
								</div>
								<div class="profile__meta">
									<h3>{{Auth::guard('visitor')->user()->name}}</h3>
								</div>
							</div>

							<!-- content tabs nav -->
							<ul class="nav nav-tabs content__tabs content__tabs--profile" id="content__tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Profile</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Settings</a>
								</li>
								<li class="nav-item">
                                    @if (session('error'))
									    <h3 class="success text_center btn bg_danger"><span class="color_light">{{session('error')}}</span></h3>
                                    @endif


                                    @if (session('current_password'))
									    <h3 class="success text_center btn bg_danger"><span class="color_light">{{session('current_password')}}</span></h3>
                                    @endif
                                    @if (session('password'))
									    <h3 class="success text_center btn bg_danger"><span class="color_light">{{session('password')}}</span></h3>
                                    @endif
                                    @if (session('password_confirmation'))
									    <h3 class="success text_center btn bg_danger"><span class="color_light">{{session('password_confirmation')}}</span></h3>
                                    @endif

                                    @if (session('success'))
									    <h3 class="success text_center btn bg_success"><span class="color_light">{{session('success')}}</span></h3>
                                    @endif


								</li>

							</ul>
							<!-- end content tabs nav -->

							<!-- content mobile tabs nav -->
							<div class="content__mobile-tabs content__mobile-tabs--profile" id="content__mobile-tabs">
								<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<input type="button" value="Profile">
									<span></span>
								</div>

								<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Profile</a></li>

										<li class="nav-item"><a class="nav-link" id="3-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Settings</a></li>

									</ul>
								</div>
							</div>
							<!-- end content mobile tabs nav -->

							<a href="{{route('visitor.logout')}}" class="profile__logout">
								<i class="icon ion-ios-log-out"></i>
								<span>Logout</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end profile -->

		<div class="container">
			<!-- content tabs -->
			<div class="tab-content">
				<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
					<div class="row row--grid">


						<!-- dashbox -->
						<div class="col-12 col-xl-6">
                              <div class="col-lg-12">
                                    <div class="dashbox">
                                        <div class="dashbox__title">
                                            <h3><i class="icon ion-ios-film"></i> Your Favorite Movies </h3>
                                        </div>

                                        <div class="dashbox__table-wrap">
                                            <table class="main__table main__table--dash">
                                                <thead>
                                                    <tr>
                                                        <th>TITLE</th>
                                                        <th>Year</th>
                                                        <th>RATING</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($favorites as $favorite )

                                                    <tr>
                                                        <td>
                                                            <div class="main__table-text"><a href="{{route('movie.details',$favorite->movie->url)}}">{{ strlen($favorite->movie->title) > 45 ? substr($favorite->movie->title, 0, 45) . '...' : $favorite->movie->title }}</a></div>
                                                        </td>
                                                        <td>
                                                            <div class="main__table-text">{{$favorite->movie->release_year}}</div>
                                                        </td>
                                                        <td>
                                                            <div class="main__table-text main__table-text--rate"><i class="icon {{$favorite->movie->rating >= 6?'ion-ios-star':''}}"></i> {{$favorite->movie->rating}}</div>
                                                        </td>
                                                    </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
						</div>
						<!-- end dashbox -->

						<!-- dashbox -->
						<div class="col-12 col-xl-6">
                            <div class="col-lg-12">
                                <div class="dashbox">
                                    <div class="dashbox__title">
                                        <h3><i class="icon ion-ios-star-half"></i> Your Total Comments  &nbsp; - &nbsp; {{$count}}</h3>
                                    </div>

                                    <div class="dashbox__table-wrap">
                                        <table class="main__table main__table--dash">
                                            <thead>
                                                <tr>
                                                    <th>Comment</th>
                                                    <th>Movie</th>
                                                    <th>Date</th>
                                                    <th><i class="icon ion-md-thumbs-up"></i></th>
                                                    <th><i class="icon ion-md-thumbs-down"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($comments as $comment )
                                                <tr>
                                                    <td>
                                                        <div class="main__table-text"><a href="#">{{ strlen($comment->comment) > 10 ? substr($comment->comment, 0, 10) . '...' : $comment->comment }}</a></div>
                                                    </td>
                                                    <td>
                                                        <div class="main__table-text"><a href="{{route('movie.details',$comment->movie->url)}}">{{ strlen($comment->movie->title) > 35 ? substr($comment->movie->title, 0, 35) . '...' : $comment->movie->title }}</a></div>
                                                    </td>
                                                    <td>
                                                        <div class="main__table-text main__table-text--rate">{{$comment->created_at->format('d M y')}}</div>
                                                    </td>
                                                    <td>
                                                        <div class="main__table-text main__table-text--rate">{{App\Models\CommentLikeModel::where('comment_id', $comment->id)->where('like', 1)->count()}}</div>
                                                    </td>
                                                    <td>
                                                        <div class="main__table-text main__table-text--rate">{{App\Models\CommentLikeModel::where('comment_id', $comment->id)->where('dislike', 1)->count()}}</div>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
						</div>
						<!-- end dashbox -->
					</div>
				</div>

				<div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="3-tab">
					<div class="row">
						<!-- details form -->
						<div class="col-12 col-lg-6">
							<form action="{{route('profileChange')}}" class="form form--profile" method="POST">
                                @csrf
								<div class="row row--form">
									<div class="col-12">
										<h4 class="form__title">Profile details</h4>
									</div>


									<div class="col-12 col-md-12 col-lg-12 col-xl-12">
										<div class="form__group">
											<label class="form__label" for="email">Email</label>
											<input id="email" type="text" name="email" class="form__input" value="{{Auth::guard('visitor')->user()->email}}" disabled>
										</div>
									</div>

									<div class="col-12 col-md-12 col-lg-12 col-xl-12 mt-3">
										<div class="form__group">
											<label class="form__label" for="firstname">Name</label>
											<input id="firstname" type="text" name="name" class="form__input" placeholder="Name" value="{{Auth::guard('visitor')->user()->name}}">
										</div>
									</div>


									<div class="col-12 mt-3">
										<button class="form__btn" type="submit">Save</button>
									</div>
								</div>
							</form>
						</div>
						<!-- end details form -->

						<!-- password form -->
						<div class="col-12 col-lg-6">
							<form action="{{route('profilePassChange')}}" class="form form--profile" method="POST">
                                @csrf
								<div class="row row--form">
									<div class="col-12">
										<h4 class="form__title">Change password</h4>
									</div>

									<div class="col-12 col-md-12 col-lg-12 col-xl-12">
										<div class="form__group">
											<label class="form__label" for="oldpass">Old password</label>
											<input id="oldpass" type="password" name="current_password" class="form__input @error('password') wrong @enderror{{session('current_password')?'wrong':''}}">
										</div>
									</div>

									<div class="col-12 col-md-6 col-lg-12 col-xl-6 mt-2">
										<div class="form__group">
											<label class="form__label" for="newpass">New password</label>
											<input id="newpass" type="password" name="password" class="form__input @error('password') wrong @enderror" >

										</div>
									</div>

									<div class="col-12 col-md-6 col-lg-12 col-xl-6 mt-2">
										<div class="form__group">
											<label class="form__label" for="confirmpass">Confirm new password</label>
											<input id="confirmpass" type="password" name="password_confirmation" class="form__input @error('password_confirmation') wrong @enderror">
										</div>
									</div>



									<div class="col-12 mt-3">
										<button class="form__btn" type="submit">Change</button>
									</div>
								</div>
							</form>
						</div>
						<!-- end password form -->
					</div>
				</div>
			</div>
			<!-- end content tabs -->
		</div>
	</div>
	<!-- end content -->
@endsection




