@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">UPDATE NEAR BY TEMPLE</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('templeuser/manage-nearbytemple') }}"
                        class="btn btn-info text-white">Manage Near By Temple</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
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
                    <form action="{{ route('updateNearByTemple', $nearbyTemple->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="name">Temple Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $nearbyTemple->name) }}" required>
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="place_type">Place Type</label>
                                <input type="text" class="form-control" id="place_type" name="place_type" value="{{ old('place_type', $nearbyTemple->place_type) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="photo">Photos</label>
                                <input type="file" class="form-control" id="photo" name="photo[]" multiple>
                                @if($nearbyTemple->photo)
                                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#photoModal">View</button>
                    
                                    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="photoModalLabel">Temple Photos</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @foreach(json_decode($nearbyTemple->photo, true) as $image)
                                                        <img src="{{ asset($image) }}" class="img-thumbnail m-2" width="150">
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="cover_photo">Cover Photo</label>
                                <input type="file" class="form-control" id="cover_photo" name="cover_photo">
                                @if($nearbyTemple->cover_photo)
                                    <div class="mt-2">
                                        <img src="{{ asset($nearbyTemple->cover_photo) }}" alt="Cover Photo" width="100">
                                    </div>
                                @endif
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="map_photo">Map Photo</label>
                                <input type="file" class="form-control" id="map_photo" name="map_photo">
                                @if($nearbyTemple->map_photo)
                                    <div class="mt-2">
                                        <img src="{{ asset($nearbyTemple->map_photo) }}" alt="Map Photo" width="100">
                                    </div>
                                @endif
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="google_map_link">Google Map Link</label>
                                <input type="url" class="form-control" id="google_map_link" name="google_map_link" value="{{ old('google_map_link', $nearbyTemple->google_map_link) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="estd_date">Established Date</label>
                                <input type="date" class="form-control" id="estd_date" name="estd_date" value="{{ old('estd_date', $nearbyTemple->estd_date) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="estd_by">Established By</label>
                                <input type="text" class="form-control" id="estd_by" name="estd_by" value="{{ old('estd_by', $nearbyTemple->estd_by) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="committee_name">Committee Name</label>
                                <input type="text" class="form-control" id="committee_name" name="committee_name" value="{{ old('committee_name', $nearbyTemple->committee_name) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="contact_no">Contact Number</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no', $nearbyTemple->contact_no) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="whatsapp_no">WhatsApp Number</label>
                                <input type="text" class="form-control" id="whatsapp_no" name="whatsapp_no" value="{{ old('whatsapp_no', $nearbyTemple->whatsapp_no) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $nearbyTemple->email) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="priest_name">Priest Name</label>
                                <input type="text" class="form-control" id="priest_name" name="priest_name" value="{{ old('priest_name', $nearbyTemple->priest_name) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="priest_contact_no">Priest Contact Number</label>
                                <input type="text" class="form-control" id="priest_contact_no" name="priest_contact_no" value="{{ old('priest_contact_no', $nearbyTemple->priest_contact_no) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="distance_from_temple">Distance From Temple (km)</label>
                                <input type="text" class="form-control" id="distance_from_temple" name="distance_from_temple" value="{{ old('distance_from_temple', $nearbyTemple->distance_from_temple) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="country">Country</label>
                                <select class="form-control" id="country" name="country">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $nearbyTemple->country == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="state">State</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $nearbyTemple->state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="district">District</label>
                                <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $nearbyTemple->district) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="city_village">City/Village</label>
                                <input type="text" class="form-control" id="city_village" name="city_village" value="{{ old('city_village', $nearbyTemple->city_village) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="landmark">Landmark</label>
                                <input type="text" class="form-control" id="landmark" name="landmark" value="{{ old('landmark', $nearbyTemple->landmark) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $nearbyTemple->pincode) }}">
                            </div>
                    
                            <div class="col-md-12 form-group">
                                <label for="history">History</label>
                                <textarea class="form-control" id="history" name="history">{{ old('history', $nearbyTemple->history) }}</textarea>
                            </div>
                    
                            <div class="col-md-12 form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description', $nearbyTemple->description) }}</textarea>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-success mt-3">Update</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

     <!-- JavaScript for Dynamic State Population -->
     <script>
        document.getElementById('country').addEventListener('change', function() {
            var countryId = this.value;
            fetch(`/get-states/${countryId}`)
                .then(response => response.json())
                .then(data => {
                    let stateDropdown = document.getElementById('state');
                    stateDropdown.innerHTML = '<option value="">Select State</option>';
                    data.forEach(state => {
                        stateDropdown.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                    });
                });
        });
    </script>
    
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
