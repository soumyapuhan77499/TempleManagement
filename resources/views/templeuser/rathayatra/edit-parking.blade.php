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
                        @method('PUT') <!-- Use PUT method for update -->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="odia" @if($parking->language == 'odia') selected @endif>Odia</option>
                                        <option value="english" @if($parking->language == 'english') selected @endif>English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking_name">Parking Name</label>
                                    <input type="text" class="form-control" id="parking_name" name="parking_name" placeholder="Enter parking name" value="{{ $parking->parking_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking_availability">Parking Availability</label>
                                    <input type="text" class="form-control" id="parking_availability" name="parking_availability" placeholder="Enter parking availability" value="{{ $parking->parking_availability }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="map_url">Map URL</label>
                                    <input type="text" class="form-control" id="map_url" name="map_url" placeholder="Enter URL..." value="{{ $parking->map_url }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Vehicle Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="two_wheeler" name="vehicle_type" value="Two Wheeler" @if($parking->vehicle_type == 'Two Wheeler') checked @endif>
                                        <label class="form-check-label" for="two_wheeler">Two Wheeler</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="four_wheeler" name="vehicle_type" value="Four Wheeler" @if($parking->vehicle_type == 'Four Wheeler') checked @endif>
                                        <label class="form-check-label" for="four_wheeler">Four Wheeler</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking_photo">Photo</label>
                                    <input type="file" class="form-control" id="parking_photo" name="parking_photo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="parking_address">Parking Address</label>
                                    <textarea class="form-control" id="parking_address" name="parking_address" placeholder="Enter parking address">{{ $parking->parking_address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px;">
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
