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
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('updateParking', $parking->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
    
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
                                    <label for="parking_name">Parking Name</label>
                                    <input type="text" class="form-control" id="parking_name" name="parking_name" value="{{ $parking->parking_name }}" placeholder="Enter parking name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking_availability">Parking Availability</label>
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
                                    @if ($parking->parking_photo)
                                        <img src="{{ asset($parking->parking_photo) }}" alt="Parking Photo" class="mt-2" style="width: 100px; height: 100px;">
                                    @endif
                                </div>
                            </div>
                        </div>
    
                        <!-- Pass Type Section -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Who Can Park</label>
                                    <div class="d-flex flex-wrap">
                                        @php $selectedPassTypes = json_decode($parking->pass_type, true) ?? []; @endphp
                                        @foreach (['vip', 'vvip', 'normal', 'sebayat'] as $type)
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" name="pass_type[]" value="{{ $type }}" {{ in_array($type, $selectedPassTypes) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ ucfirst($type) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
    
                            <!-- Vehicle Type Section -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Vehicle Type</label>
                                    <div class="d-flex flex-wrap">
                                        @php $selectedVehicleTypes = json_decode($parking->vehicle_type, true) ?? []; @endphp
                                        @foreach (['two wheeler', 'four wheeler', 'three wheeler', 'heavy vehicle', 'electric vehicle'] as $vehicle)
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" name="vehicle_type[]" value="{{ $vehicle }}" {{ in_array($vehicle, $selectedVehicleTypes) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ ucfirst($vehicle) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
    
                            <!-- Parking Area Type -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Parking Area Type</label>
                                    <div class="d-flex flex-wrap">
                                        @php $selectedAreaTypes = json_decode($parking->area_type, true) ?? []; @endphp
                                        @foreach (['cover' => 'Covered', 'open' => 'Open'] as $key => $label)
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" name="area_type[]" value="{{ $key }}" {{ in_array($key, $selectedAreaTypes) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <!-- Parking Management -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Parking Management</label>
                                    <div class="d-flex flex-wrap">
                                        @php $selectedManagements = json_decode($parking->parking_management, true) ?? []; @endphp
                                        @foreach (['automated', 'manual'] as $management)
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" name="parking_management[]" value="{{ $management }}" {{ in_array($management, $selectedManagements) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ ucfirst($management) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <h5 class="mt-4">Address Details</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control" id="country" name="country">
                                        <option value="India">India</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select class="form-control" id="state" name="state">
                                        <option value="Odisha">Odisha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <input type="text" class="form-control" id="district" name="district" value="{{ $parking->district }}" placeholder="Enter district">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="landmark">Landmark</label>
                                    <input type="text" class="form-control" id="landmark" name="landmark" value="{{ $parking->landmark }}" placeholder="Enter landmark">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode" value="{{ $parking->pincode }}" placeholder="Enter pincode">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_village">City/Village</label>
                                    <input type="text" class="form-control" id="city_village" name="city_village" value="{{ $parking->city_village }}" placeholder="Enter city or village">
                                </div>
                            </div>
                        </div>
    
                        <div class="mt-4 text-center">
                            <input type="submit" class="btn btn-primary" value="Update">
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
