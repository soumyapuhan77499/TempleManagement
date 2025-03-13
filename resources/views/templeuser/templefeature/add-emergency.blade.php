@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD EMERGENCY</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ route('manageEmergency') }}"
                        class="btn btn-warning text-white">Manage Emergency</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('saveEmergency') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="emergency_type">Emergency Type</label>
                                    <select class="form-control select2" name="emergency_type" id="emergency_type">
                                        <option value="police">Police</option>
                                        <option value="ambulance">Ambulance</option>
                                        <option value="fire">Fire</option>
                                        <option value="hospital">Hospital</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="google_map_link">Google Map Link</label>
                                    <input type="text" class="form-control" name="google_map_link" id="google_map_link">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country" id="country" value="India">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" name="state" id="state" value="Odisha">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <input type="text" class="form-control" name="district" id="district">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="landmark">Landmark</label>
                                    <input type="text" class="form-control" name="landmark" id="landmark">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" name="pincode" id="pincode">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city_village">City/Village</label>
                                    <input type="text" class="form-control" name="city_village" id="city_village">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" style="padding-top: 27px">
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Form-layouts js -->
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            let errorMessages = "";
            @foreach ($errors->all() as $error)
                errorMessages += "{{ $error }}\n";
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                text: errorMessages,
            });
        </script>
    @endif
@endsection
