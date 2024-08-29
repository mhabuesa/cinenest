
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

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>HotFlix – Online Movies, TV Shows & Cinema HTML Template</title>
</head>

<body class="body">

	<div class="sign section--bg" data-bg="{{asset('frontend')}}/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						<!-- registration form -->
						<form action="{{route('visitor.store')}}" method="POST" class="sign__form">
                            @csrf
							<a href="index.html" class="sign__logo">
								<img src="{{asset('frontend')}}/img/logo.png" alt="">
							</a>

							<div class="sign__group">
								<input type="text" name="name" class="sign__input" placeholder="Name" value="{{old('name')}}">
                                @error('name')
                                    <small class="text_danger">{{$message}}</small>
                                @enderror
							</div>

							<div class="sign__group">
								<input type="email" name="email" class="sign__input" placeholder="Email" value="{{old('email')}}">
                                @error('email')
                                    <small class="text_danger">{{$message}}</small>
                                @enderror
							</div>

							<div class="sign__group">
								<input type="password" name="password" class="sign__input" placeholder="Password">
                                @error('password')
                                    <small class="text_danger">{{$message}}</small>
                                @enderror
							</div>
							<div class="sign__group">
								<input type="password" name="password_confirmation" class="sign__input" placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <small class="text_danger">{{$message}}</small>
                                @enderror
							</div>

							<div class="sign__group sign__group--checkbox">
								<input id="remember" name="remember" type="checkbox" checked="checked">
								<label for="remember">I agree to the <a href="{{route('privacyPolicy')}}">Privacy Policy</a></label>
							</div>

							<button class="sign__btn" type="submit">Sign up</button>

							<span class="sign__text">Already have an account? <a href="{{route('signin')}}">Sign in!</a></span>
						</form>
						<!-- registration form -->
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


