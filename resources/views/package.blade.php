@extends('layout')
<style>
    .page-title-area.bg-primary-light {
    display: none;
}

</style>
@section('pagename')
    {{ __('Package') }}
@endsection

@section('content')

    <!--====== Start contacts-section ======-->
    <div class="pricing-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic" type="button">Basic</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#premium" type="button">Premium</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pro" type="button">Pro</button>
                            </li>
                        </ul>
                    </div>
    
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="basic">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-flex align-items-center">
                                            <div class="icon"><i class="fas fa-check-circle"></i></div>
                                            <div class="label">
                                                <h4>Basic Plan</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center my-3">
                                            <span class="price">$10</span>
                                            <span class="period">/ month</span>
                                        </div>
                                        <h5>What's Included</h5>
                                        <ul class="pricing-list list-unstyled p-0" data-more="Show More" data-less="Show Less">
                                            <li><i class="fal fa-check"></i> Feature 1</li>
                                            <li><i class="fal fa-check"></i> Feature 2</li>
                                            <li><i class="fal fa-times"></i> Feature 3</li>
                                        </ul>
                                        <div class="btn-groups">
                                            <a href="#" class="btn btn-lg btn-primary no-animation">Trial</a>
                                            <a href="#" class="btn btn-lg btn-outline no-animation">Signup</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-flex align-items-center">
                                            <div class="icon"><i class="fas fa-check-circle"></i></div>
                                            <div class="label">
                                                <h4>Basic Plan</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center my-3">
                                            <span class="price">$10</span>
                                            <span class="period">/ month</span>
                                        </div>
                                        <h5>What's Included</h5>
                                        <ul class="pricing-list list-unstyled p-0" data-more="Show More" data-less="Show Less">
                                            <li><i class="fal fa-check"></i> Feature 1</li>
                                            <li><i class="fal fa-check"></i> Feature 2</li>
                                            <li><i class="fal fa-times"></i> Feature 3</li>
                                        </ul>
                                        <div class="btn-groups">
                                            <a href="#" class="btn btn-lg btn-primary no-animation">Trial</a>
                                            <a href="#" class="btn btn-lg btn-outline no-animation">Signup</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-flex align-items-center">
                                            <div class="icon"><i class="fas fa-check-circle"></i></div>
                                            <div class="label">
                                                <h4>Basic Plan</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center my-3">
                                            <span class="price">$10</span>
                                            <span class="period">/ month</span>
                                        </div>
                                        <h5>What's Included</h5>
                                        <ul class="pricing-list list-unstyled p-0" data-more="Show More" data-less="Show Less">
                                            <li><i class="fal fa-check"></i> Feature 1</li>
                                            <li><i class="fal fa-check"></i> Feature 2</li>
                                            <li><i class="fal fa-times"></i> Feature 3</li>
                                        </ul>
                                        <div class="btn-groups">
                                            <a href="#" class="btn btn-lg btn-primary no-animation">Trial</a>
                                            <a href="#" class="btn btn-lg btn-outline no-animation">Signup</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add more package cards as needed -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="premium">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-flex align-items-center">
                                            <div class="icon"><i class="fas fa-star"></i></div>
                                            <div class="label">
                                                <h4>Premium Plan</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center my-3">
                                            <span class="price">$20</span>
                                            <span class="period">/ month</span>
                                        </div>
                                        <h5>What's Included</h5>
                                        <ul class="pricing-list list-unstyled p-0" data-more="Show More" data-less="Show Less">
                                            <li><i class="fal fa-check"></i> Feature 1</li>
                                            <li><i class="fal fa-check"></i> Feature 2</li>
                                            <li><i class="fal fa-check"></i> Feature 3</li>
                                        </ul>
                                        <div class="btn-groups">
                                            <a href="#" class="btn btn-lg btn-outline no-animation">Purchase</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pro">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-flex align-items-center">
                                            <div class="icon"><i class="fas fa-crown"></i></div>
                                            <div class="label">
                                                <h4>Pro Plan</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center my-3">
                                            <span class="price">$30</span>
                                            <span class="period">/ month</span>
                                        </div>
                                        <h5>What's Included</h5>
                                        <ul class="pricing-list list-unstyled p-0" data-more="Show More" data-less="Show Less">
                                            <li><i class="fal fa-check"></i> Feature 1</li>
                                            <li><i class="fal fa-check"></i> Feature 2</li>
                                            <li><i class="fal fa-check"></i> Feature 3</li>
                                        </ul>
                                        <div class="btn-groups">
                                            <a href="#" class="btn btn-lg btn-outline no-animation">Purchase</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bg Shape -->
      
    </div>
    
    
    <!--====== End contacts-section ======-->
@endsection