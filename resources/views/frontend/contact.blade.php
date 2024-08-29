@extends('layouts.frontend')
@section('content')
    <!-- page title -->
	<section class="section section--first section--bg" data-bg="{{asset('frontend')}}/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h1 class="section__title">Contact</h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="{{route('index')}}">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Contact</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

    <!-- contacts -->
<section class="section">
    <div class="container">
        <div class="row">
            <div style="margin: 0 auto" class="text_center col-12 col-md-7 col-xl-8">
                <!-- section title -->
                <div class="col-12">
                    <h2 class="section__title section__title--mb">Contact Form</h2>

                </div>
                <!-- end section title -->

                <div class="col-12">
                    <h4 class="bg_primary contact_form_header">If you have any suggestions, Please Tell Us</h4>
                    @if (session('sent'))
                    <h4 class="bg_success contact_form_error">{{session('sent')}}</h4>
                    @endif
                    <form action="{{route('contact.send')}}" class="form form--contacts" method="POST">
                        @csrf
                        <div class="row row--form">
                            <div class="col-12 col-xl-6 mb_3">
                                <input type="text" class="form__input" name="name" placeholder="Name" required>
                                @error('name')
                                    <span class="color_danger mt-0" >{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-xl-6 mb_3">
                                <input type="text" class="form__input" name="email" placeholder="Email" required>
                                @error('email')
                                    <span class="color_danger mt-0" >{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb_3">
                                <input type="text" class="form__input" name="subject" placeholder="Subject" required>
                                @error('subject')
                                    <span class="color_danger mt-0" >{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb_3">
                                <textarea id="text" name="message" class="form__textarea" placeholder="Type your message..." required></textarea>
                                @error('message')
                                    <span class="color_danger mt-0" >{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb_3">
                                <button type="submit" class="form__btn">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end contacts -->
@endsection
