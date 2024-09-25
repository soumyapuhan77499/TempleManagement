<!DOCTYPE html>
<html lang="en" >
<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('og-meta')
    <!--====== Title ======-->
    <title>@yield('pagename')</title>
    <!--====== Favicon Icon ======-->
    {{-- <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/png"> --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}">
    {{-- <!--====== Bootstrap css ======-->
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{asset('assets/front/css/default.css')}}">
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/cookie-alert.css')}}">
    @if ($rtl == 1)
        <link rel="stylesheet" href="{{asset('assets/front/css/rtl-style.css')}}">
    @endif --}}
    <!-- base color change -->
    {{-- <link href="{{ asset('assets/front/css/style-base-color.php') . '?color=' . $bs->base_color }}" rel="stylesheet"> --}}
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/fonts/fontawesome/css/all.min.css') }}">
        <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/swiper-bundle.min.css') }}">
    <!-- Kreativ Icon -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/fonts/icomoon/style.css') }}">
    {{-- Toastr css  --}}
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/toastr.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/magnific-popup.min.css') }}">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/aos.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/nice-select.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/style.css') }}">
    <!-- summernote Style CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/summernote-content.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/responsive.css') }}">
    {{-- @if ($rtl == 1) --}}
        {{-- <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/rtl.css') }}"> --}}
    {{-- @endif --}}
    <!-- base color change -->
    {{-- <link href="{{ asset('front-assets/frontend/css/style-base-color.php') . '?color=' . $bs->base_color }}"
        rel="stylesheet"> --}}

    @yield('styles')

    {{-- @if ($bs->is_whatsapp == 0 && $bs->is_tawkto == 0)
        <style>
            .back-to-top {
                left: auto;
                right: 30px;
            }
        </style>
    @endif --}}
    {{-- <style>
        {!! $be->custom_css !!}
    </style>
    @php
        $primaryRgbColor = hex2rgb($bs->base_color);
    @endphp --}}
    <style>
         :root {
            --color-primary: #FF6B6B;
            --color-primary-shade: ;
            --bg-light: #14;
            --color-primary-rgb: 255,107,107;

        }
    </style>
        <style>
       

       .popup {
    display: block;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 70px 100px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    z-index: 1000;
    background-color: rgba(21, 120, 179, 0.9);
    border-radius: 10px;
    color: #fff;
}
.popup form#myForm {
    width: 1320px;
}
.popup label {
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 1px;
}
  .popup input.cstm-btn {
    background: #ffff;
    border: none;
    outline: none;
    padding: 15px 70px;
    border-radius: 10px;
}
.popup h4{
    color: #ffff;
}
.popup .form-control {
    
    color: #ffff;
   
}
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
 @media screen and(max-width:400px) {
            
        }
    </style>
  <!-- <style>
  

    .popup {
        width:430px;
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      /* background-color: #fff; */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      
    /* position: relative; */
    /* text-align: center; */
    background-color: rgba(255, 40, 101, 0.7);
    border-radius: 10px;
    padding: 90px 55px;

      
    }
.cstm-btn{
    width: 316px;
    border-radius: 7px;
    border: 1px solid #1578b3;
    background: #1578b3;
    padding: 12px;
    color: #fff;
    font-size: 17px;
    letter-spacing: 1px;
}
    .overlay {
    /* display: none; */
    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -287px;
    margin-left: -647px;
    width: 1300px;
    height: 551px;
    padding: 10px;
    background-image: url("http://localhost:8000/assets/front/img/popups/6577f0b3b7afc.png");
    background-size: cover;
    background-repeat: no-repeat;
    z-index: 999;
    border-radius: 30px;
}
label {
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 1px;
}
  
  </style> -->

    {{-- @if(!is_null($bs->adsense_publisher_id))
    <!------google adsense----------->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{$bs->adsense_publisher_id}}" crossorigin="anonymous"></script>
    <!------google adsense----------->
    @endif --}}
</head>

<body>

    <!--====== Start Preloader ======-->
    <div id="preLoader">
        <div class="loader">
            <img src="{{ asset('front-assets/frontend/images/WhatsApp Image 2024-09-19 at 12.52.04 PM.jpeg')}}" alt="Loader"> <!-- Replace with actual preloader image -->
        </div>
    </div>
    <!--====== End Preloader ======-->

    <!-- Header -->
    @includeIf('partials.header')

    <!-- Breadcrumbs -->
    <div class="page-title-area bg-primary-light">
        <div class="container">
            <div class="content text-center">
                <h2>Page Title</h2> <!-- Replace with actual title -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Current Page</li> <!-- Replace with actual page -->
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Bg Overlay -->
        <img class="lazyload bg-overlay-1" data-src="front-assets/frontend/images/shadow-1.png" alt="Bg">
        <img class="lazyload bg-overlay-2" data-src="front-assets/frontend/images/shadow-2.png" alt="Bg">

        <!-- Bg Shape -->
        <div class="shape">
            <img class="shape-1" src="front-assets/frontend/images/shape/shape-4.png" alt="Shape">
            <img class="shape-2" src="front-assets/frontend/images/shape/shape-5.png" alt="Shape">
            <img class="shape-3" src="front-assets/frontend/images/shape/shape-6.png" alt="Shape">
            <img class="shape-4" src="front-assets/frontend/images/shape/shape-7.png" alt="Shape">
            <img class="shape-5" src="front-assets/frontend/images/shape/shape-8.png" alt="Shape">
            <img class="shape-6" src="front-assets/frontend/images/shape/shape-9.png" alt="Shape">
        </div>
    </div>
    <!--====== End Breadcrumbs-section ======-->

    <!-- Content -->
    @yield('content')

    <!-- Footer Section -->
    @includeIf('partials.footer')

    <!-- Go to Top -->
    <div class="go-top"><i class="fal fa-angle-double-up"></i></div>
    <!-- Go to Top -->

    <!-- Magic Cursor -->
    <div class="cursor"></div>
    <!-- Magic Cursor -->

    <!-- Cookie Alert -->
    {{-- <div class="cookie">
        @include('cookie-consent::index')
    </div> --}}

    <!-- Popups -->
    {{-- @includeIf('front.partials.popups') --}}

    <!-- WhatsApp Chat Button -->
    <div id="WAButton"></div>

    <!-- Jquery JS -->
    <script src="front-assets/frontend/js/jquery.min.js"></script>
    <script src="assets/front/js/plugin.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="front-assets/frontend/js/bootstrap.min.js"></script>
    <!-- Nice Select JS -->
    <script src="front-assets/frontend/js/jquery.nice-select.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="front-assets/frontend/js/jquery.magnific-popup.min.js"></script>
    <!-- Swiper Slider JS -->
    <script src="front-assets/frontend/js/swiper-bundle.min.js"></script>
    <!-- Lazysizes -->
    <script src="front-assets/frontend/js/lazysizes.min.js"></script>
    <!-- SVG loader -->
    <script src="front-assets/frontend/js/svg-loader.min.js"></script>
    <!-- AOS JS -->
    <script src="front-assets/frontend/js/aos.min.js"></script>
    <script src="front-assets/frontend/js/toastr.min.js"></script>

    <script>
        "use strict";
        var rtl = false; // Hardcoded for static version
    </script>

    <!-- Main script JS -->
    <script src="front-assets/frontend/js/script.js"></script>

   

</body>


</html>
