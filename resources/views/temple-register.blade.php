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
                        class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-45 justify-content-center">
                        <div class="card-sigin mt-5 mt-md-0">
                            <!-- Demo content-->
                            <div class="main-card-signin d-md-flex">
                                <div class="wd-100p">
                                    <div class="d-flex mb-4" style="justify-content: center;">
                                        <a href="#">
                                            <img src="{{ asset('assets/img/brand/logo2.png') }}" class="sign-favicon ht-80"
                                                alt="logo">
                                        </a>
                                    </div>
                                    <div class="">
                                        <div class="main-signup-header">

                                            <div class="tab-menu-heading mb-2 border-bottom-0">
                                                <div class="tabs-menu1">
                                                    <ul class="nav panel-tabs">
                                                        <li class="me-2"><a href="#tab5" class="active"
                                                                data-bs-toggle="tab">Register</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="panel-body tabs-menu-body border-0 p-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab5">
                                                        @if(session('success'))
                                                        <div class="alert alert-success">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif
                                                    
                                                    @if(session('error'))
                                                        <div class="alert alert-danger">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif
                                                        <form action="/templeuser/temple-register" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="temple_name">Temple Name<span
                                                                                style="color: red">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            id="temple_name" name="temple_name"
                                                                            placeholder="Enter Temple Name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="temple_trust_name">Temple Trust
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="temple_trust_name" name="temple_trust_name"
                                                                            placeholder="Enter Trust Name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="trust_contact_no">Trust Contact
                                                                            Number</label>
                                                                        <input type="text" class="form-control"
                                                                            id="trust_contact_no" name="trust_contact_no"
                                                                            placeholder="Enter Trust Contact No.">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="user_name">User Name<span
                                                                                style="color: red">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            id="user_name" name="user_name"
                                                                            placeholder="Enter User Name" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="mobile_no">User Contact
                                                                            Number<span style="color: red">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            id="mobile_no" name="mobile_no"
                                                                            placeholder="Enter Contact No." required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="temple_address">Temple Address<span
                                                                                style="color: red">*</span></label>
                                                                        <textarea class="form-control" name="temple_address" id="temple_address"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary"
                                                                style="margin-top: 20px">Submit</button>

                                                                <p class="mt-3">
                                                                   If already have account please?  <a href="/templeuser/templelogin" class="text-primary">Login</a>
                                                                </p>
        
                                                        </form>
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
    
    @endsection
