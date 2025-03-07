@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">PARKING DETAILS</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('templeuser/manage-parking') }}"
                        class="btn btn-warning text-dark">Manage Parking</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">Parking</li>
            </ol>
        </div>
    </div>
    

    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('saveParking') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="odia">Odia</option>
                                        <option value="english">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="notice">Parking Name</label>
                                    <input type="text" class="form-control" id="parking" name="parking"
                                        placeholder="Enter parking name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="availability">Parking Availability</label>
                                    <input type="text" class="form-control" id="availability" name="availability"
                                        placeholder="Enter parking availability">
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="map_url">Map URL</label>
                                    <input type="text" class="form-control" id="map_url" name="map_url"
                                        placeholder="Enter URL...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking_photo">Photo</label>
                                    <input type="file" class="form-control" id="parking_photo" name="parking_photo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Vehicle Type Section -->
                                <div class="form-group row">
                                    <label for="vehicle_type" class="col-sm-4 col-form-label">Vehicle Type</label>
                                    <div class="col-sm-10 d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="two_wheeler"
                                                name="vehicle_type" value="two_wheeler">
                                            <label class="form-check-label" for="two_wheeler">Two Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="four_wheeler"
                                                name="vehicle_type" value="four_wheeler">
                                            <label class="form-check-label" for="four_wheeler">Four Wheeler</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="both"
                                                name="vehicle_type" value="both">
                                            <label class="form-check-label" for="both">Both</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                           
                            <div class="col-md-4">
                                <!-- Pass Type Section -->
                                <div class="form-group row">
                                    <label for="pass_type" class="col-sm-4 col-form-label">Pass Type</label>
                                    <div class="col-sm-10 d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="vip"
                                                name="pass_type" value="vip">
                                            <label class="form-check-label" for="vip">Vip</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="vvip"
                                                name="pass_type" value="vvip">
                                            <label class="form-check-label" for="vvip">Vvip</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="normal"
                                                name="pass_type" value="normal">
                                            <label class="form-check-label" for="normal">Normal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="all"
                                                name="pass_type" value="all">
                                            <label class="form-check-label" for="all">All</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="parking_address">Parking Address</label>
                                    <textarea class="form-control" id="parking_address" name="parking_address"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('scripts')
    <!-- Form-layouts js -->
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

    <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    });
</script>
@endif
@endsection
