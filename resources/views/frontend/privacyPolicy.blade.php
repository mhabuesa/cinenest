@extends('layouts.frontend')
@section('content')
    <!-- page title -->
	<section class="section section--first section--bg" loading="lazy" data-bg="{{asset('frontend')}}/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h1 class="section__title">Privacy Policy </h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="{{route('index')}}">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Privacy Policy </li>
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
                    <h3>Privacy Policy  for  <a href="{{route('index')}}" class="color_primary" title="Website">CineNest</a> .</h3>
					<p class="section__text">
                        we operates the <a href="{{route('index')}}" class="color_primary" title="Website">CineNest</a> website. This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data..
                    </p>

                    <h3 class="mt-5">Information Collection and Use.</h3>
					<p class="section__text">
                        We do not collect any personal information from our users. Our primary goal in collecting information is to provide and improve our Service. The information we collect is strictly limited to non-personal data such as:
                    </p>


                    <ol class="color_light">
                        <li>Log Data: We collect information that your browser sends whenever you visit our Service ("Log Data"). This Log Data may include information such as your computer's Internet Protocol ("IP") address, browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages, and other statistics.</li>

                    </ol>

                    <h3 class="mt-5">Cookies.</h3>
                    <p class="section__text">
                        We use cookies and similar tracking technologies to track the activity on our Service and hold certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier. Cookies are sent to your browser from a website and stored on your device. Tracking technologies also used are beacons, tags, and scripts to collect and track information and to improve and analyze our Service.
                    </p>
                    <p class="section__text">
                        You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.
                    </p>

                    <h3 class="mt-5">Third-Party Services.</h3>
                    <p class="section__text">
                        We do not use third-party services to collect personal information. However, we may use third-party services for analytics purposes to improve our Service. These services may collect, monitor, and analyze Log Data to help us understand how our Service is used.
                    </p>

                    <h3 class="mt-5">Links to Other Sites.</h3>
                    <p class="section__text">
                        Our Service may contain links to other sites that are not operated by us. If you click on a third-party link, you will be directed to that third party's site. We strongly advise you to review the Privacy Policy of every site you visit. <br>
                        We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.
                    </p>

                    <h3 class="mt-5">Children's Privacy.</h3>
                    <p class="section__text">
                        Our Service does not address anyone under the age of 13 ("Children"). We do not knowingly collect personally identifiable information from anyone under the age of 13. If you are a parent of children please keep them away from this website. Although it does not contain any objectionable content
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
