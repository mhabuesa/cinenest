@push('title')
<title>Disclaimer | CineNest – Online Movies, TV Shows, Cinema Website</title>
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
    <!-- page title -->
	<section class="section section--first section--bg" data-bg="{{asset('frontend')}}/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h1 class="section__title">Disclaimer</h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="{{route('index')}}">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Disclaimer</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

    <!-- privacy -->
	<section class="section">
		<div class="container">
			<div class="row">
				<!-- section text -->
				<div class="col-10 m-auto">
                    <h3>Disclaimer for  <a href="{{route('index')}}" class="color_primary" title="Website">CineNest</a> .</h3>
					<p class="section__text">
                        None of the files mentioned on this site are stored on our server. All files are hosted on third-party file hosting services. <a href="{{route('index')}}" class="color_primary" title="Website">CineNest</a> is not responsible for the content hosted on external websites and has no involvement with such content.
                    </p>

                    <h3 class="mt-5">Copyrighted Material.</h3>
                    <h6 class="fs_3">How to request the removal of copyrighted material from our website?</h6>
					<p class="section__text">
                        Please note that we do not store any copyrighted material on this site. The information provided here contains only data shared on the internet and does not include any copyrighted material. However, we offer a service to remove content from our website if requested by the copyright holder. Removal requests will be processed only if:
                    </p>


                    <ol class="color_light">
                        <li>You or your organization are the copyright owner of the material in question.</li>
                        <li>You provide the exact URLs to the material.</li>
                        <li>You provide the full name(s) of the material in question.</li>
                        <li>You send the removal request from a verifiable email address (e.g., address@yourname/yourcompany.com).</li>
                    </ol>

                    <p class="section__text">
                        If your request meets all of these criteria, please send a message via our Contact Us page. Ensure that your correspondence is courteous. <br>
                        We will remove the specified postings as soon as possible, typically within 4 days. Please note that we can only process removal requests that comply with the above criteria.
                    </p>

                    <p class="section__text">
                        Thanks ❤️
                    </p>

				</div>
				<!-- end section text -->
			</div>
		</div>
	</section>
	<!-- end privacy -->
@endsection
