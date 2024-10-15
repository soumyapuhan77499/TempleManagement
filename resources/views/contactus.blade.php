@extends('layout')
<style>
    .page-title-area.bg-primary-light {
    display: none;
}

</style>
@section('pagename')
    {{ __('Contact') }}
@endsection

@section('content')

    <!--====== Start contacts-section ======-->
    <div class="contact-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 blue" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon">
                                    <i class="fal fa-phone-plus"></i>
                                </div>
                                <div class="card-text">
                                    <p><a href="tel:+1234567890">+1234567890</a></p>
                                    <p><a href="tel:+9876543210">+9876543210</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-30 green" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="card-text">
                                    <p><a href="mailTo:example@mail.com">example@mail.com</a></p>
                                    <p><a href="mailTo:info@mail.com">info@mail.com</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card mb-50 orange" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="card-text">
                                    <p>1234 Street Name, City, Country</p>
                                    <p>5678 Avenue Name, City, Country</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="row justify-content-center">
                        <div class="col-lg-8 offset-lg-2 mb-30" data-aos="fade-up" data-aos-delay="100">
                            <form id="contactForm" action="/submit-contact" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="text" name="name" class="form-control" id="name" required
                                                data-error="Enter your name" placeholder="Full Name*" />
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input type="email" name="email" class="form-control" id="email" required
                                                data-error="Enter your email" placeholder="Email Address*" />
                                        </div>
                                    </div>
    
                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <input type="text" name="subject" class="form-control" id="subject" required
                                                data-error="Enter your subject" placeholder="Subject*" />
                                        </div>
                                    </div>
    
                                    <div class="col-md-12">
                                        <div class="form-group mb-30">
                                            <textarea name="message" id="message" class="form-control" cols="30" rows="8" required
                                                data-error="Please enter your message" placeholder="Message"></textarea>
                                        </div>
                                    </div>
    
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-primary" title="Send message">Submit</button>
                                        <div id="msgSubmit"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
    
    <!--====== End contacts-section ======-->
@endsection