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
                                <!-- Pass Type Section -->
                                <div class="form-group row">
                                    <label for="pass_type" class="col-sm-4 col-form-label">Who Can Park</label>
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

                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="all"
                                                name="sebayat" value="sebayat">
                                            <label class="form-check-label" for="sebayat">Sebayat</label>
                                        </div>

                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="all"
                                                name="pass_type" value="all">
                                            <label class="form-check-label" for="all">All</label>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Vehicle Type Section -->
                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="vehicle_type" class="form-label">Vehicle Type</label>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="two_wheeler" name="vehicle_type" value="two wheeler">
                                            <label class="form-check-label" for="two_wheeler">Two Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="four_wheeler" name="vehicle_type" value="four wheeler">
                                            <label class="form-check-label" for="four_wheeler">Four Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="three_wheeler" name="vehicle_type" value="three wheeler">
                                            <label class="form-check-label" for="three_wheeler">Three Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="heavy_vehicle" name="vehicle_type" value="heavy vehicle">
                                            <label class="form-check-label" for="heavy_vehicle">Heavy Vehicle</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="electric_vehicle" name="vehicle_type" value="electric vehicle">
                                            <label class="form-check-label" for="electric_vehicle">Electric Vehicle</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="all" name="vehicle_type" value="all">
                                            <label class="form-check-label" for="all">All</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Parking Area Type Section -->
                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="area_type" class="form-label">Parking Area Type</label>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="cover" name="area_type" value="cover">
                                            <label class="form-check-label" for="cover">Covered</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="open" name="area_type" value="open">
                                            <label class="form-check-label" for="open">Open</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Parking Management Section -->
                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="parking_management" class="form-label">Parking Management</label>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="automated" name="parking_management" value="automated">
                                            <label class="form-check-label" for="automated">Automated</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" id="manual" name="parking_management" value="manual">
                                            <label class="form-check-label" for="manual">Manual</label>
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
