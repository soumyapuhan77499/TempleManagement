@extends('layouts.custom-app')

@section('styles')
@endsection

@section('class')
    <div class="bg-primary">
    @endsection

    @section('content')
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-45 justify-content-center">
                        <div class="card-sigin mt-5 mt-md-0">
                            <!-- Demo content-->
                            <div class="main-card-signin d-md-flex">
                                <div class="wd-100p">
                                    <div class="d-flex justify-content-center align-items-center mb-4">
                                        <a href="#"><img src="{{ asset('assets/img/brand/logo2.png') }}" class="sign-favicon ht-80" alt="logo"></a>
                                    </div>
                                    
                                    <div class="">
                                        <div class="main-signup-header">
                                            <div class="panel panel-primary">
                                                <div class="tab-menu-heading mb-2 border-bottom-0">
                                                    <div class="tabs-menu1">
                                                        <ul class="nav panel-tabs">
                                                            <li class="me-2"><a href="#tab5" class="active" data-bs-toggle="tab">Login</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-body tabs-menu-body border-0 p-3">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab5">
                                                            <!-- Display Success Message -->
                                                            @if (session('message'))
                                                                <div class="alert alert-success">
                                                                    {{ session('message') }}
                                                                </div>
                                                            @endif
                                                            <!-- Display Error Message -->
                                                            @if (session('error'))
                                                                <div class="alert alert-danger">
                                                                    {{ session('error') }}
                                                                </div>
                                                            @endif

                                                            @if (session('otp_sent'))
                                                                <!-- OTP Verification Form -->
                                                                <form action="/templeuser/verify-otp" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" name="order_id" value="{{ session('otp_order_id') }}">
                                                                    <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
                                                                    <input type="hidden" class="form-control" name="phone" value="{{ session('otp_phone') }}">
                                                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Verify OTP</button>
                                                                </form>
                                                            @else
                                                                <!-- OTP Generation Form -->
                                                                <form action="/templeuser/send-otp" method="POST">
                                                                    @csrf
                                                                    <div id="step1">
                                                                        <div class="form-group">
                                                                            <div style="display: flex; align-items: center;">
                                                                                <input type="text" class="form-control" value="+91" readonly
                                                                                    style="background-color: #f1f1f1; width: 60px; text-align: center;">
                                                                                    <input type="text" class="form-control" id="phone" name="phone"
                                                                                    placeholder="Enter your phone number" maxlength="10" 
                                                                                    style="margin-left: 5px; flex: 1;" required
                                                                                    pattern="\d*" title="Please enter only numbers" 
                                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <input type="submit" class="btn btn-primary" value="Generate OTP">
                                                                    </div>
                                                                </form>
                                                            @endif

                                                            <!-- Sign Up Link -->
                                                            <p class="mt-3">
                                                                Don't have an account? <a href="/templeuser/temple-register" class="text-primary">Sign Up</a>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- generate-otp js -->
        <script>
            setTimeout(function() {
                document.getElementById('Message').style.display = 'none';
            }, 3000);
            setTimeout(function() {
                document.getElementById('Messages').style.display = 'none';
            }, 3000);
        </script>
        <script src="{{ asset('assets/js/generate-otp.js') }}"></script>
    @endsection
