<!--====== Start Footer ======-->
{{-- <footer class="footer-area bg-primary-light"> --}}
<footer class="footer-area">
        <!-- Video Background -->
        <video autoplay muted loop id="footerVideo" class="footer-bg-video">
            <source src="{{asset('/front-assets/images/bg-video2.mp4')}}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <div class="footer-top pt-120 pb-90">
        <div class="container">
            <div class="row gx-xl-5 justify-content-between">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="100">
                        <div class="navbar-brand">
                            <a href="{{ url('/') }}">
                                <img class="lazyload" src="{{ asset('front-assets/images/logo.png') }}" alt="Footer Logo">
                            </a>
                        </div>
                        <p>We strive to provide top-quality services and innovative solutions to help your business thrive. Let's achieve success together.</p>

                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3 col-sm">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="200">
                        <h5>Useful Links</h5>
                        <ul class="footer-links">
                            <li><a href="link1.html">Home</a></li>
                            <li><a href="link2.html">About Us</a></li>
                            <li><a href="link3.html">Services</a></li>
                            <li><a href="link4.html">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="400">
                        <h5>Contact Us</h5>
                        <ul class="info-list">
                            <li>
                                <i class="fal fa-map-marker-alt"></i>
                                <span>33Crores Pooja Products Pvt Ltd ,
                                    403, 4th Floor, O-Hub
                                    IDCO Sez Infocity,
                                    Bhubaneswar 751024,
                                    Odisha , Bharat</span>
                            </li>
                            <li>
                                <i class="fal fa-phone-plus"></i>
                                <div>
                                    <a href="tel:+123456789">+123 456 789</a>
                                </div>
                            </li>
                            <li>
                                <i class="fal fa-envelope"></i>
                                <div>
                                    <a href="mailto:info@example.com">info@example.com</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                        <h5>Subscribe to Our Newsletter</h5>
                        <p class="lh-1 mb-20">Stay updated with our latest news and offers.</p>
                        <div class="newsletter-form">
                            <form id="newsletterForm" class="subscribeForm" action="#" method="POST">
                                <div class="form-group">
                                    <input class="form-control radius-sm" placeholder="Enter Your Email" type="email" name="email" required autocomplete="off">
                                    <button class="newsletter-btn btn btn-md btn-primary radius-sm no-animation" type="submit">
                                        <i class="fal fa-paper-plane"></i>
                                    </button>
                                </div>
                                <p id="erremail" class="text-danger mb-0 err-email"></p>
                                <div class="form-group mt-3">
                                    <!-- Optional CAPTCHA Section -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copy-right-area border-top">
        <div class="container">
            <div class="copy-right-content">
                <div class="social-link justify-content-center mb-2">
                    <a href="https://instagram.com" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://facebook.com" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                </div>

                <span>© 2024 Your Company Name. All rights reserved.</span>
            </div>
        </div>
    </div>
</footer>

<!--====== End Footer ======-->
