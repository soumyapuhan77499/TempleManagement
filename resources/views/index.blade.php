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
        {{-- <img class="lazyload shape-8" data-src="{{asset('front-assets/frontend/shapes/8.png')}}" alt="Shape" style="    width: 60px;"> --}}
       
    </div>
  </section>
  <!-- Home End -->
  <!--- process section --->
  <section class="store-area pb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="section-title title-inline mb-50" data-aos="fade-up">
                    <h2 class="title">Our Work Process</h2> <!-- Static title -->
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-30 item" data-aos="fade-up">
                        <div class="card">
                            <div class="card-icon">
                                <img class="lazyload" data-src="front-assets/front/img/process/1694935495.png" alt="Icon"> <!-- Static image path -->
                            </div>
                            <div class="card-content">
                                <a href="javascript:void(0)">
                                    <h4 class="card-title">Add Your Temple</h4> <!-- Static title -->
                                </a>
                                <p class="card-text">
                                    Begin by adding your temple's details to our platform. Showcase its history, significance, and unique offerings to engage your visitors. <!-- Static subtitle -->
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-30 item" data-aos="fade-up">
                        <div class="card">
                            <div class="card-icon">
                                <img class="lazyload" data-src="front-assets/front/img/process/1690004588.png" alt="Icon"> <!-- Static image path -->
                            </div>
                            <div class="card-content">
                                <a href="javascript:void(0)">
                                    <h4 class="card-title">Customize Services</h4> <!-- Static title -->
                                </a>
                                <p class="card-text">
                                    Tailor your website by adding the services that reflect your business. We provide the flexibility to showcase exactly what you offer. <!-- Static subtitle -->
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-30 item" data-aos="fade-up">
                        <div class="card">
                            <div class="card-icon">
                                <img class="lazyload" data-src="front-assets/front/img/process/1694935625.png" alt="Icon"> <!-- Static image path -->
                            </div>
                            <div class="card-content">
                                <a href="javascript:void(0)">
                                    <h4 class="card-title">Configure Your Site</h4> <!-- Static title -->
                                </a>
                                <p class="card-text">
                                    Let us take care of setting up your website, ensuring it's optimized for your needs and ready to go live without hassle. <!-- Static subtitle -->
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-30 item" data-aos="fade-up">
                        <div class="card">
                            <div class="card-icon">
                                <img class="lazyload" data-src="front-assets/front/img/process/1694935679.png" alt="Icon"> <!-- Static image path -->
                            </div>
                            <div class="card-content">
                                <a href="javascript:void(0)">
                                    <h4 class="card-title">Launch Your Site</h4> <!-- Static title -->
                                </a>
                                <p class="card-text">
                                    Go live with confidence! Present a polished, fully operational website that attracts and engages your target audience.

                                    <!-- Static subtitle -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bg Shape -->
    <div class="shape">
        <img class="shape-1" src="front-assets/frontend/shapes/10.png" alt="Shape" style="    width: 60px;">
        <img class="shape-2" src="front-assets/frontend/shapes/13.jpeg" alt="Shape" style="    width: 60px;">
        <img class="shape-3" src="front-assets/frontend/shapes/9.png" alt="Shape" style="    width: 60px;">
        <img class="shape-4" src="front-assets/frontend/shapes/18.jpeg" alt="Shape" style="    width: 60px;">
       
    </div>
  </section>
<!-- Template Start -->
<section class="template-area bg-primary-light ptb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="section-title title-center mb-50" data-aos="fade-up">
                    <span class="subtitle">Temples That Reflect Our Divine Culture</span>
                    <h2 class="title mt-0">Explore Our Temples</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                        <div class="card text-center mb-50">
                            <div class="card-image">
                                <div class="lazy-container">
                                    <img class="lazyload lazy-image" src="front-assets/frontend/images/2023-07-10.jpg" alt="Demo Image" />
                                </div>
                                <div class="hover-show">
                                    <a href="http://home.mandirparikrama.com/kunjabihari/" target="_blank" class="btn-icon rounded-circle" title="View Details">
                                        <i class="fal fa-link"></i>
                                    </a>
                                </div>
                            </div>
                            <h4 class="card-title">
                                <a href="http://home.mandirparikrama.com/kunjabihari/" title="Link" target="_blank"> Kunjabihari Temple</a>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                        <div class="card text-center mb-50">
                            <div class="card-image">
                                <div class="lazy-container">
                                    <img class="lazyload lazy-image" src="front-assets/frontend/images/temple2.png" alt="Demo Image" style="object-fit: cover;
    height: 390px;" />
                                </div>
                                <div class="hover-show">
                                    <a href="http://home.mandirparikrama.com/nilakantheswar/" target="_blank" class="btn-icon rounded-circle" title="View Details">
                                        <i class="fal fa-link"></i>
                                    </a>
                                </div>
                            </div>
                            <h4 class="card-title">
                                <a href="http://home.mandirparikrama.com/nilakantheswar/" title="Link" target="_blank">Nilakantheswar Temple</a>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6" data-aos="fade-up">
                        <div class="card text-center mb-50">
                            <div class="card-image">
                                <div class="lazy-container">
                                    <img class="lazyload lazy-image" src="front-assets/images/2023-04-04.jpg" alt="Demo Image" />
                                </div>
                                <div class="hover-show">
                                    <a href="#" target="_blank" class="btn-icon rounded-circle" title="View Details">
                                        <i class="fal fa-link"></i>
                                    </a>
                                </div>
                            </div>
                            <h4 class="card-title">
                                <a href="#" title="Link" target="_blank">Lingraj Temple</a>
                            </h4>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <a href="all-templates.html" class="btn btn-lg btn-primary" title="More Templates" target="_blank">More Temples</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bg Shape -->
    <div class="shape">
       
        <img class="lazyload shape-4" data-src="{{asset('front-assets/frontend/shapes/2.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-5" data-src="{{asset('front-assets/frontend/shapes/5.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-6" data-src="{{asset('front-assets/frontend/shapes/6.png')}}" alt="Shape" style="    width: 60px;">
        <img class="lazyload shape-8" data-src="{{asset('front-assets/frontend/shapes/8.png')}}" alt="Shape" style="    width: 60px;">
       
    </div>
</section>
<!-- Template End -->

    <!-- Testimonial Start -->
    <section class="testimonial-area pb-80 pt-120">
        <div class="container">
            <div class="row align-items-center gx-xl-5">
                <div class="col-lg-6">
                    <div class="content mb-30" data-aos="fade-up">
                        <h2 class="title">What Our Clients Say</h2>
                    </div>
                    <div class="swiper testimonial-slider mb-40" data-aos="fade-up">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="slider-item bg-primary-light">
                                    <div class="ratings justify-content-between size-md">
                                        <div class="rate">
                                            <div class="rating-icon" style="width: 80%!important"></div>
                                        </div>
                                        <span class="ratings-total">4 Stars</span>
                                    </div>
                                    <div class="quote">
                                        <p class="text mb-0">
                                            "Amazing service and support, highly recommend!"
                                        </p>
                                    </div>
                                    <div class="client flex-wrap">
                                        <div class="client-info d-flex align-items-center">
                                            <div class="client-img">
                                                <div class="lazy-container ratio ratio-1-1">
                                                    <img class="lazyload" src="front-assets/images/1637215604.png" alt="Person Image">
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h6 class="name">John Doe</h6>
                                                <span class="designation">CEO, Company</span>
                                            </div>
                                        </div>
                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="slider-item bg-primary-light">
                                    <div class="ratings justify-content-between size-md">
                                        <div class="rate">
                                            <div class="rating-icon" style="width: 100%!important"></div>
                                        </div>
                                        <span class="ratings-total">5 Stars</span>
                                    </div>
                                    <div class="quote">
                                        <p class="text mb-0">
                                            "Exceptional quality and attention to detail!"
                                        </p>
                                    </div>
                                    <div class="client flex-wrap">
                                        <div class="client-info d-flex align-items-center">
                                            <div class="client-img">
                                                <div class="lazy-container ratio ratio-1-1">
                                                    <img class="lazyload" src="front-assets/images/1637215604.png" alt="Person Image">
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h6 class="name">Jane Smith</h6>
                                                <span class="designation">Marketing Head</span>
                                            </div>
                                        </div>
                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination" id="testimonial-slider-pagination" data-min data-max></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image mb-40" data-aos="fade-left">
                        <img src="front-assets/frontend/images/testimonial.png" alt="Testimonial Image">
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
        <div class="shape">
            <img class="lazyload shape-4" data-src="{{asset('front-assets/frontend/shapes/2.png')}}" alt="Shape" style="    width: 60px;">
            <img class="lazyload shape-5" data-src="{{asset('front-assets/frontend/shapes/5.png')}}" alt="Shape" style="    width: 60px;">
            <img class="lazyload shape-6" data-src="{{asset('front-assets/frontend/shapes/6.png')}}" alt="Shape" style="    width: 60px;">
            <img class="lazyload shape-8" data-src="{{asset('front-assets/frontend/shapes/8.png')}}" alt="Shape" style="    width: 60px;">
           
        </div>
    </section>
    <!-- Testimonial End -->


@endsection
