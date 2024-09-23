<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Temple Management System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />


	<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="{{ asset('front-assets/css/animate.css')}}">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="{{asset('front-assets/css/icomoon.css')}}">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="{{asset('front-assets/css/bootstrap.css')}}">
	<!-- Theme style  -->
	<link rel="stylesheet" href="{{asset('front-assets/css/style.css')}}">

	<!-- Modernizr JS -->
	<script src="{{asset('front-assets/js/modernizr-2.6.2.min.js')}}"></script>
	

	</head>
	<body>
		
	<div class="fh5co-loader"></div>
	
	<div id="page">
	<nav class="fh5co-nav" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 text-left">
					<div id="fh5co-logo"><a href="{{url('/')}}"><img src="{{asset('assets/img/brand/logo.png')}}" class="mobile-logo logo-1" alt="logo" style="    width: 200px;"></a></div>
				</div>
				<div class="col-xs-6 text-right">
					<a href="{{route('templelogin')}}" target="_blank" class="btn btn-primary">Temple Login</a>
					<a href="{{route('temple-register')}}" target="_blank" class="btn btn-primary">Temple Register</a>

				</div>
			</div>
		</div>
		
	</nav>

	<header id="fh5co-header" class="fh5co-cover" role="banner" style="background-image:url(front-assets/images/img_bg_1.jpg);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<div class="display-t">
						<div class="display-tc animate-box" data-animate-effect="fadeIn">
							<h1>We Are Coming Very Soon!</h1>
							
							<div class="simply-countdown simply-countdown-one"></div>
							<div class="row">
								<h2>Stay Connected: Join Us on Our Journey!</h2>
								
								<ul class="fh5co-social-icons">
									<li><a href="#"><i class="icon-twitter-with-circle"></i></a></li>
									<li><a href="#"><i class="icon-facebook-with-circle"></i></a></li>
									<li><a href="#"><i class="icon-linkedin-with-circle"></i></a></li>
									<li><a href="#"><i class="icon-dribbble-with-circle"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<footer id="fh5co-footer" role="contentinfo">
		<div class="container">

			<div class="row copyright">
				<div class="col-md-12 text-center">
					<p>
						<small class="block">&copy; 2024. All Rights Reserved.</small> 
						<small class="block">Designed by <a href="http://freehtml5.co/" target="_blank">33Crores</a></small>
					</p>
					<p>
						<ul class="fh5co-social-icons">
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-linkedin"></i></a></li>
							<li><a href="#"><i class="icon-dribbble"></i></a></li>
						</ul>
					</p>
				</div>
			</div>

		</div>
	</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="{{ asset('front-assets/js/jquery.min.js')}}"></script>
	<!-- jQuery Easing -->
	<script src="{{ asset('front-assets/js/jquery.easing.1.3.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('front-assets/js/bootstrap.min.js')}}"></script>
	<!-- Waypoints -->
	<script src="{{ asset('front-assets/js/jquery.waypoints.min.js')}}"></script>

	<!-- Stellar -->
	<script src="{{ asset('front-assets/js/jquery.stellar.min.js')}}"></script>

	<!-- Count Down -->
	<script src="{{ asset('front-assets/js/simplyCountdown.js')}}"></script>
	<!-- Main -->
	<script src="{{ asset('front-assets/js/main.js')}}"></script>

	<script>
    var d = new Date(new Date().getTime() + 800 * 120 * 120 * 2000);

    // default example
    simplyCountdown('.simply-countdown-one', {
        year: d.getFullYear(),
        month: d.getMonth() + 1,
        day: d.getDate()
    });

    //jQuery example
    $('#simply-countdown-losange').simplyCountdown({
        year: d.getFullYear(),
        month: d.getMonth() + 1,
        day: d.getDate(),
        enableUtc: false
    });
</script>

	</body>
</html>

