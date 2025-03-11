@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">UPDATE ACCOMODATION</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('templeuser/manage-accomodation') }}"
                        class="btn btn-warning text-dark">Manage Accomodation</a></li>
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
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('updateAccomodation', $accomodation->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
    
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $accomodation->name }}" required>
                                </div>
                            </div>
    
                            <!-- Photos -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="photos">Photos</label>
                                    <input type="file" class="form-control" id="photos" name="photos[]" multiple>
                                    <small>Leave blank if you don't want to update images</small>
                                </div>
                                @if($accomodation->photo)
                                    @foreach(json_decode($accomodation->photo) as $photo)
                                        <img src="{{ asset($photo) }}" width="100px" height="100px" class="mt-2">
                                    @endforeach
                                @endif
                            </div>
    
                            <!-- Google Map Link -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="google_map_link">Google Map Link</label>
                                    <input type="url" class="form-control" id="google_map_link" name="google_map_link" value="{{ $accomodation->google_map_link }}" required>
                                </div>
                            </div>
    
                            <!-- Accommodation Type -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="accomodation_type">Accommodation Type</label>
                                    <select class="form-control select2" id="accomodation_type" name="accomodation_type" required onchange="toggleFields()">
                                        <option value="bhakta_niwas" {{ $accomodation->accomodation_type == 'bhakta_niwas' ? 'selected' : '' }}>Bhakta Niwas</option>
                                        <option value="yatri_niwas" {{ $accomodation->accomodation_type == 'yatri_niwas' ? 'selected' : '' }}>Yatri Niwas</option>
                                        <option value="dharamasala" {{ $accomodation->accomodation_type == 'dharamasala' ? 'selected' : '' }}>Dharamasala</option>
                                        <option value="hotel" {{ $accomodation->accomodation_type == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                        <option value="restaurant" {{ $accomodation->accomodation_type == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                    </select>
                                </div>
                            </div>
    
                            <!-- Restaurant Fields (Hidden by default) -->
                            <div class="col-md-4 restaurant-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="opening_time">Opening Time</label>
                                    <input type="time" class="form-control" id="opening_time" name="opening_time" value="{{ $accomodation->opening_time ?? '' }}">
                                </div>
                            </div>
    
                            <div class="col-md-4 restaurant-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="closing_time">Closing Time</label>
                                    <input type="time" class="form-control" id="closing_time" name="closing_time" value="{{ $accomodation->closing_time ?? '' }}">
                                </div>
                            </div>
    
                            <div class="col-md-4 restaurant-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="food_type">Food Type</label>
                                    <select class="form-control" id="food_type" name="food_type">
                                        <option value="veg" {{ $accomodation->food_type == 'veg' ? 'selected' : '' }}>Vegetarian</option>
                                        <option value="non_veg" {{ $accomodation->food_type == 'non_veg' ? 'selected' : '' }}>Non-Vegetarian</option>
                                        <option value="both" {{ $accomodation->food_type == 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                </div>
                            </div>
    
                            <!-- Contact Details -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $accomodation->contact_no }}" required>
                                </div>
                            </div>
    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="whatsapp_no">WhatsApp No</label>
                                    <input type="text" class="form-control" id="whatsapp_no" name="whatsapp_no" value="{{ $accomodation->whatsapp_no }}" required>
                                </div>
                            </div>
    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $accomodation->email }}" required>
                                </div>
                            </div>
    
                            <!-- Check-In & Check-Out (Hidden for Restaurant) -->
                            <div class="col-md-4 check-fields">
                                <div class="form-group">
                                    <label for="check_in_time">Check-In Time</label>
                                    <input type="time" class="form-control" id="check_in_time" name="check_in_time" value="{{ $accomodation->check_in_time }}">
                                </div>
                            </div>
    
                            <div class="col-md-4 check-fields">
                                <div class="form-group">
                                    <label for="check_out_time">Check-Out Time</label>
                                    <input type="time" class="form-control" id="check_out_time" name="check_out_time" value="{{ $accomodation->check_out_time }}">
                                </div>
                            </div>
    
                            <!-- Address & Description -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ $accomodation->address }}</textarea>
                                </div>
                            </div>
    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $accomodation->description }}</textarea>
                                </div>
                            </div>
                        </div>
    
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <input type="submit" class="btn btn-success" value="Update">
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

   
    <!-- JavaScript to Toggle Fields -->
    <script>
        function toggleFields() {
            var type = document.getElementById("accomodation_type").value;
            var restaurantFields = document.querySelectorAll(".restaurant-fields");
            var checkFields = document.querySelectorAll(".check-fields");
        
            restaurantFields.forEach(field => field.style.display = (type === "restaurant") ? "block" : "none");
            checkFields.forEach(field => field.style.display = (type === "restaurant") ? "none" : "block");
        }
        
        // Call function on page load
        document.addEventListener("DOMContentLoaded", toggleFields);
        </script>
    
@endsection
