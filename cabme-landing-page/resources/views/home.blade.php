<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"      

	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="icon" type="image/png" href="https://cabme-landing.siswebapp.com/img/fav.png">
	    <title>{{ config('app.name', 'Laravel') }}</title>
	    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
	    <script type="490cf4da05ddb33bf38d2254-text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	</head>
	
	<body class="fixed-bottom-bar">
	
		@if(@$cmspage)
		<header class="section-header">
	      <div class="container">
	        <div class="row">
	          <div class="main-logo col-md-6">
	            <div class="site-logo">
	              <a href="https://cabme-landing.siswebapp.com"> <img class="img-fluid" src="https://cabme-landing.siswebapp.com/img/logo_header.png" alt="logo"> </a>
	            </div>
	          </div>
	
	          <div class="header-right col-md-6 text-right">
	            <ul class="menu">
	              <li>
	                <a href="#our-mission">Our Mission</a>
	              </li>
	              <li>
	                <a href="#how-it-works">How it Works</a>
	              </li>
	              <li>
	                <a href="#mobile-app">Mobile App</a>
	              </li>
	            </ul>
	          </div>
	        </div>
	      </div>
		</header>
	
	    <div class="siddhi-cms-pages" style="padding-top:70px;">
			<div class="container">
				<div class="cms-page pt-5 pb-3">
					<h1 class="head pt-3 pb-3">{{$cmspage->cms_name}}</h1>
					<div class="content">
						{!! $cmspage->cms_desc !!}
					</div>			
				</div>
			</div>
	   </div>
	
	    <footer class="section-footer border-top bg-dark">
	      <div class="container">
	        <section class="footer-top pb-5 text-center pt-0">
	          <div class="ft-logo mb-5">
	            <img src="https://cabme-landing.siswebapp.com/img/footer-logo.png" alt="Logo">
	          </div>
	          <div class="footer-tp-middel d-flex align-items-center mb-5">
	            <div class="ft-social">
	              <ul>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/fb_footer.png" alt="facebook"></a>
	                </li>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/twitter_footer.png" alt="twitter"></a>
	                </li>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/insta_footer.png" alt="instagram"></a>
	                </li>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/pentrest_footer.png" alt="pinterest"></a>
	                </li>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/g+_footer.png" alt="google"></a>
	                </li>
	              </ul>
	            </div>
	            <div class="ft-app-link ml-3">
	              <ul>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/appstore_footer.png" alt="App Store"></a>
	                </li>
	                <li>
	                  <a href="#"><img src="https://cabme-landing.siswebapp.com/img/google_play_footer.png" alt="App Store"></a>
	                </li>
	
	              </ul>
	            </div>
	          </div>
	          <div class="footer-tp-bottom">
	            <div class="contact-info">
	              <h3>CONTACT US</h3>
	              <ul>
	                <li>
	                  <a href="tel:552532560235"><img src="https://cabme-landing.siswebapp.com/img/call.png" alt="info"> +55 253 2560 235</a>
	                </li>
	                <li>
	                  <a href="mailto:info.cabme@gmail.com"><img src="https://cabme-landing.siswebapp.com/img/mail.png" alt="info"> info.cabme@gmail.com</a>
	                </li>
	
	              </ul>
	            </div>
	          </div>
	        </section>
	        <section class="footer-copyright border-top py-3">
	          <div class="container text-center">
	            <p class="mb-0">
	              © Copyright 2022-2023 Cabme. All rights reserved.</p><p class="mb-0">hello</p><p class="mb-0">
	            </p>
	          </div>
	        </section>
	      </div>
	      <a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>
	    </footer>
	
		@else
			{!! $landingpage->html_template !!}
		@endif
		
	</body>
</html>
