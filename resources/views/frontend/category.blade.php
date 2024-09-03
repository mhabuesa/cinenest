@push('title')
<title>{{$category->category}} | CineNest – Online Movies, TV Shows, Cinema Website</title>
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
						<h1 class="section__title">{{$category->category}}</h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="{{route('index')}}">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">{{$category->category}}</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

    @livewire('category', [
        'slug'=>$slug
    ])
@include('frontend.share_icon')
@endsection
