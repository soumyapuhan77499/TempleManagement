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
                    <form action="{{ route('updateNearByTemple', $temple->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Required for updating -->
                        
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="temple_name">Temple Name</label>
                                <input type="text" class="form-control" id="temple_name" name="temple_name" value="{{ old('temple_name', $temple->temple_name) }}" required>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="photo">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo[]" multiple>
                            
                                @if($temple->photo)
                                    <!-- Button to open modal -->
                                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#imageModal">
                                        View
                                    </button>
                            
                                    <!-- Modal -->
                                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel">Temple Photos</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @foreach(json_decode($temple->photo, true) as $image)
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
                                <label for="google_map_link">Google Map Link</label>
                                <input type="url" class="form-control" id="google_map_link" name="google_map_link" value="{{ old('google_map_link', $temple->google_map_link) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="estd_date">Established Date</label>
                                <input type="date" class="form-control" id="estd_date" name="estd_date" value="{{ old('estd_date', $temple->estd_date) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="estd_by">Established By</label>
                                <input type="text" class="form-control" id="estd_by" name="estd_by" value="{{ old('estd_by', $temple->estd_by) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="committee_name">Committee Name</label>
                                <input type="text" class="form-control" id="committee_name" name="committee_name" value="{{ old('committee_name', $temple->committee_name) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="contact_no">Contact Number</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no', $temple->contact_no) }}" required>
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="whatsapp_no">WhatsApp Number</label>
                                <input type="text" class="form-control" id="whatsapp_no" name="whatsapp_no" value="{{ old('whatsapp_no', $temple->whatsapp_no) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $temple->email) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="priest_name">Priest Name</label>
                                <input type="text" class="form-control" id="priest_name" name="priest_name" value="{{ old('priest_name', $temple->priest_name) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="priest_contact_no">Priest Contact Number</label>
                                <input type="text" class="form-control" id="priest_contact_no" name="priest_contact_no" value="{{ old('priest_contact_no', $temple->priest_contact_no) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="area_type">Temple Type</label>
                                <select class="form-control" id="area_type" name="area_type" required>
                                    <option value="">Select Type</option>
                                    <option value="worldwide" {{ old('area_type', $temple->area_type) == 'worldwide' ? 'selected' : '' }}>Worldwide</option>
                                    <option value="inside_india" {{ old('area_type', $temple->area_type) == 'inside_india' ? 'selected' : '' }}>Inside India</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="country">Country</label>
                                <select class="form-control" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $temple->country == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-md-3 form-group">
                                <label for="state">State</label>
                                <select class="form-control" id="state" name="state" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $temple->state == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="district">District</label>
                                <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $temple->district) }}" required>
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="landmark">Landmark</label>
                                <input type="text" class="form-control" id="landmark" name="landmark" value="{{ old('landmark', $temple->landmark) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $temple->pincode) }}">
                            </div>
                    
                            <div class="col-md-3 form-group">
                                <label for="city_village">City/Village</label>
                                <input type="text" class="form-control" id="city_village" name="city_village" value="{{ old('city_village', $temple->city_village) }}">
                            </div>

                          
                    
                        
                            
                            <div class="col-md-12 form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description', $temple->description) }}</textarea>
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
