<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/owl.carousel.min.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/nouislider.min.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/ionicons.min.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/magnific-popup.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/plyr.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/photoswipe.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/default-skin.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/main.css">
	<link rel="stylesheet" href="{{asset('frontend')}}/css/custom.css">


	<!-- Favicons -->
	<link rel="icon" type="image/png" href="{{asset('frontend')}}/icon/favicon.png" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('frontend')}}/icon/favicon.png">

    <title>Signin | CineNest – Online Movies, TV Shows & Cinema Website</title>

</head>

<body class="body">

	<div class="sign section--bg" data-bg="{{asset('frontend')}}/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						<!-- authorization form -->
						<form action="{{route('visitor.signin')}}" method="POST"  class="sign__form">
                            @csrf
							<a href="{{route('index')}}" class="sign__logo">
								<img src="{{asset('frontend')}}/img/logo.png" alt="">
							</a>

                                @if(session('success'))
                                    <div class="sign__group">
                                        <p class="alert alert-success text_center">{{session('success')}}</p>
                                    </div>
                                @endif

							<div class="sign__group">
								<input type="email" name="email" class="sign__input" placeholder="Email" value="{{old('email')}}">
                                @error('email')
                                    <small class="text_danger">{{$message}}</small>
                                @enderror
                                @if(session('email'))
                                    <small class="text_danger">{{session('email')}}</small>
                                @endif
							</div>

							<div class="sign__group">
								<input type="password" name="password" class="sign__input" placeholder="Password">
                                @error('password')
                                    <small class="text_danger">{{$message}}</small>
                                @enderror
                                @if(session('password'))
                                    <small class="text_danger">{{session('password')}}</small>
                                @endif
							</div>

							<button class="sign__btn" type="submit">Sign in</button>

							<span class="sign__text">Don't have an account? <a href="{{route('signup')}}">Sign up!</a></span>

							<span class="sign__text"><a href="{{route('forget')}}">Forgot password?</a></span>
						</form>
						<!-- end authorization form -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JS -->
	<script src="{{asset('frontend')}}/js/jquery-3.5.1.min.js"></script>
	<script src="{{asset('frontend')}}/js/bootstrap.bundle.min.js"></script>
	<script src="{{asset('frontend')}}/js/owl.carousel.min.js"></script>
	<script src="{{asset('frontend')}}/js/jquery.magnific-popup.min.js"></script>
	<script src="{{asset('frontend')}}/js/jquery.mousewheel.min.js"></script>
	<script src="{{asset('frontend')}}/js/jquery.mCustomScrollbar.min.js"></script>
	<script src="{{asset('frontend')}}/js/wNumb.js"></script>
	<script src="{{asset('frontend')}}/js/nouislider.min.js"></script>
	<script src="{{asset('frontend')}}/js/plyr.min.js"></script>
	<script src="{{asset('frontend')}}/js/photoswipe.min.js"></script>
	<script src="{{asset('frontend')}}/js/photoswipe-ui-default.min.js"></script>
	<script src="{{asset('frontend')}}/js/main.js"></script>
</body>
</html>
