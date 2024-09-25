@extends('layout')
<style>
    .page-title-area.bg-primary-light {
    display: none;
}
</style>
@section('pagename')
    - {{ __('Home') }}
@endsection

@section('content')
    <!-- Home Start-->



  <div id="overlay" class="overlay"></div>
  <section id="home" class="home-banner pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="content mb-40 mx-auto text-center">
                    {{-- <span class="subtitle color-primary" data-aos="fade-up">Welcome to Our Temple Management System</span> --}}
                    <h1 class="title main-heading" data-aos="fade-up" data-aos-delay="100" style="margin-top: 41px;">
                        Manage Your Temple Activities with Ease
                    </h1>
                    <p data-aos="fade-up" data-aos-delay="150" class="main-sub-heading">
                        Our comprehensive temple management system provides a seamless way to manage events, pooja bookings, donations, and volunteer activities, ensuring a harmonious experience for all devotees.
                    </p>
                    <div class="btn-groups justify-content-center" data-aos="fade-up" data-aos-delay="200" style="    margin-top: 96px;">
                        <a href="#" class="btn btn-lg btn-primary" title="Get Started" target="_self">Get Started</a>
                        <a href="#" class="btn btn-lg btn-outline" title="Learn More" target="_self">Learn More</a>
                    </div>
                </div>
                {{-- <div class="banner-img mb-40 text-center" data-aos="fade-left">
                    <img class="lazyload"
                        data-src="front-assets/frontend/images/banner.png"
                        alt="Banner Image">
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Banner Images -->
    {{-- <div class="banner-images d-none d-lg-block">
        <img class="lazyload blur-up img-1" data-src="front-assets/frontend/images/banner-img-1.jpg" alt="Banner Image">
        <img class="lazyload blur-up img-2" data-src="front-assets/frontend/images/banner-img-2.jpg" alt="Banner Image">
        <img class="lazyload blur-up img-3" data-src="front-assets/frontend/images/banner-img-3.jpg" alt="Banner Image">
        <img class="lazyload blur-up img-4" data-src="front-assets/frontend/images/banner-img-4.jpg" alt="Banner Image">
    </div> --}}
    <!-- Bg-shape -->
    <div class="bg-shape bg-primary-light">
        <img class="lazyload" data-src="front-assets/frontend/images/banner-bg.png" alt="Shape">
    </div>
    <!-- Shape -->
    <div class="shape">
        <img class="lazyload shape-1" data-src="{{asset('front-assets/frontend/shapes/1.png')}}" alt="Shape" style="    width: ;" >
        <img class="lazyload shape-3" data-src="{{asset('front-assets/frontend/shapes/2.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-2" data-src="{{asset('front-assets/frontend/shapes/4.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-4" data-src="{{asset('front-assets/frontend/shapes/2.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-5" data-src="{{asset('front-assets/frontend/shapes/5.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-6" data-src="{{asset('front-assets/frontend/shapes/6.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-7" data-src="{{asset('front-assets/frontend/shapes/7.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-8" data-src="{{asset('front-assets/frontend/shapes/8.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-9" data-src="{{asset('front-assets/frontend/shapes/9.png')}}" alt="Shape" style="    width: 60px;">
        {{-- <img class="lazyload shape-2" data-src="front-assets/frontend/images/shape/shape-2.png" alt="Shape">
        <img class="lazyload shape-3" data-src="front-assets/frontend/images/shape/shape-3.png" alt="Shape">
        <img class="lazyload shape-4" data-src="front-assets/frontend/images/shape/shape-4.png" alt="Shape">
        <img class="lazyload shape-5" data-src="front-assets/frontend/images/shape/shape-5.png" alt="Shape">
        <img class="lazyload shape-6" data-src="front-assets/frontend/images/shape/shape-6.png" alt="Shape">
        <img class="lazyload shape-7" data-src="front-assets/frontend/images/shape/shape-7.png" alt="Shape"> --}}
    </div>
</section>

    <!-- Home End -->

@endsection
