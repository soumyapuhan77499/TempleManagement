@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">UPDATE PARKING DETAILS</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-parking') }}"
                        class="btn btn-warning text-dark">Add Parking</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">Parking</li>
            </ol>
        </div>
    </div>
    <!-- End Breadcrumb -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" id="Message">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->has('danger'))
        <div class="alert alert-danger" id="Message">
            {{ $errors->first('danger') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">
                        <form action="{{ route('updateParking', $parking->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Change method to PUT for updating an existing record -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="language">Language</label>
                                        <select class="form-control" id="language" name="language">
                                            <option value="odia" {{ $parking->language == 'odia' ? 'selected' : '' }}>Odia</option>
                                            <option value="english" {{ $parking->language == 'english' ? 'selected' : '' }}>English</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parking">Parking Name</label>
                                        <input type="text" class="form-control" id="parking_name" name="parking_name" value="{{ $parking->parking_name }}" placeholder="Enter parking name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="availability">Parking Availability</label>
                                        <input type="text" class="form-control" id="parking_availability" name="parking_availability" value="{{ $parking->parking_availability }}" placeholder="Enter parking availability">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="map_url">Map URL</label>
                                        <input type="text" class="form-control" id="map_url" name="map_url" value="{{ $parking->map_url }}" placeholder="Enter URL...">
                                    </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parking_photo">Photo</label>
                                        <input type="file" class="form-control" id="parking_photo" name="parking_photo">
                                        @if($parking->parking_photo)
                                            <img src="{{  asset( $parking->parking_photo) }}" alt="Parking Photo" style="width: 100px; height: 100px; margin-top: 10px;">
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <!-- Pass Type Section -->
                                    <div class="form-group row">
                                        <label for="pass_type" class="col-sm-4 col-form-label">Who Can Park</label>
                                        <div class="col-sm-10 d-flex">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="vip" name="pass_type" value="vip" {{ $parking->pass_type == 'vip' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vip">Vip</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="vvip" name="pass_type" value="vvip" {{ $parking->pass_type == 'vvip' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vvip">Vvip</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="normal" name="pass_type" value="normal" {{ $parking->pass_type == 'normal' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="normal">Normal</label>
                                            </div>
                        
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="sebayat" name="pass_type" value="sebayat" {{ $parking->pass_type == 'sebayat' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sebayat">Sebayat</label>
                                            </div>
                        
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="all" name="pass_type" value="all" {{ $parking->pass_type == 'all' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" id="two_wheeler" name="vehicle_type" value="two wheeler" {{ $parking->vehicle_type == 'two wheeler' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="two_wheeler">Two Wheeler</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="four_wheeler" name="vehicle_type" value="four wheeler" {{ $parking->vehicle_type == 'four wheeler' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="four_wheeler">Four Wheeler</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="three_wheeler" name="vehicle_type" value="three wheeler" {{ $parking->vehicle_type == 'three wheeler' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="three_wheeler">Three Wheeler</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="heavy_vehicle" name="vehicle_type" value="heavy vehicle" {{ $parking->vehicle_type == 'heavy vehicle' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="heavy_vehicle">Heavy Vehicle</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="electric_vehicle" name="vehicle_type" value="electric vehicle" {{ $parking->vehicle_type == 'electric vehicle' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="electric_vehicle">Electric Vehicle</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="all" name="vehicle_type" value="all" {{ $parking->vehicle_type == 'all' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" id="cover" name="area_type" value="cover" {{ $parking->area_type == 'cover' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cover">Covered</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="open" name="area_type" value="open" {{ $parking->area_type == 'open' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" id="automated" name="parking_management" value="automated" {{ $parking->parking_management == 'automated' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="automated">Automated</label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" id="manual" name="parking_management" value="manual" {{ $parking->parking_management == 'manual' ? 'checked' : '' }}>
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
                                        <textarea class="form-control" id="parking_address" name="parking_address">{{ $parking->parking_address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" style="padding-top: 27px">
                                        <input type="submit" class="btn btn-primary" value="Update">
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
@endsection
