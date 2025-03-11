@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD ACCOMODATION</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ route('manageAccomodation') }}"
                        class="btn btn-warning text-dark">Manage Accomodation</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('saveAccomodation') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Details -->
                        <h5 class="mb-3">Basic Details</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="photos">Photos</label>
                                    <input type="file" class="form-control" id="photos" name="photos[]" multiple>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="accomodation_type">Accommodation Type</label>
                                    <select class="form-control select2" id="accomodation_type" name="accomodation_type" required>
                                        <option value="bhakta_niwas">Bhakta Niwas</option>
                                        <option value="yatri_niwas">Yatri Niwas</option>
                                        <option value="dharamasala">Dharamasala</option>
                                        <option value="hotel">Hotel</option>
                                        <option value="restaurant">Restaurant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <!-- Timings -->
                        <h5 class="mt-4 mb-3">Timings</h5>
                        <div class="row check-time">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="check_in_time">Check-In Time</label>
                                    <input type="time" class="form-control" id="check_in_time" name="check_in_time">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="check_out_time">Check-Out Time</label>
                                    <input type="time" class="form-control" id="check_out_time" name="check_out_time">
                                </div>
                            </div>
                        </div>
    
                        <div class="row restaurant" style="display: none;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="opening_time">Opening Time</label>
                                    <input type="time" class="form-control" id="opening_time" name="opening_time">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="closing_time">Closing Time</label>
                                    <input type="time" class="form-control" id="closing_time" name="closing_time">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="food_type">Food Type</label>
                                    <select class="form-control select2" id="food_type" name="food_type">
                                        <option value="veg">Veg</option>
                                        <option value="non_veg">Non-Veg</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <!-- Contact Information -->
                        <h5 class="mt-4 mb-3">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="whatsapp_no">WhatsApp No</label>
                                    <input type="text" class="form-control" id="whatsapp_no" name="whatsapp_no" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="google_map_link">Google Map Link</label>
                                    <input type="url" class="form-control" id="google_map_link" name="google_map_link" required>
                                </div>
                            </div>
                        </div>
    
                        <!-- Address -->
                        <h5 class="mt-4 mb-3">Address</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="landmark">Landmark</label>
                                    <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Enter landmark">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter pincode">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_village">City/Village</label>
                                    <input type="text" class="form-control" id="city_village" name="city_village" placeholder="Enter city or village">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <input type="text" class="form-control" id="district" name="district" placeholder="Enter district">
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
                                    <label for="country">Country</label>
                                    <select class="form-control" id="country" name="country">
                                        <option value="India">India</option>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <!-- Description -->
                        <h5 class="mt-4 mb-3">Description</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
    
                        <!-- Submit Button -->
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

@section('scripts')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <script>
        document.getElementById("accomodation_type").addEventListener("change", function () {
            let selectedType = this.value;
            let checkTimeSection = document.querySelector(".check-time");
            let restaurantSection = document.querySelector(".restaurant");
            
            if (selectedType === "restaurant") {
                checkTimeSection.style.display = "none";
                restaurantSection.style.display = "flex";
            } else {
                checkTimeSection.style.display = "flex";
                restaurantSection.style.display = "none";
            }
        });
    </script>

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
            let errorMessages = `<ul style='text-align: left;'>`;
            @foreach ($errors->all() as $error)
                errorMessages += `<li>{{ $error }}</li>`;
            @endforeach
            errorMessages += `</ul>`;

            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                html: errorMessages, // Use 'html' instead of 'text' for multiple errors
            });
        </script>
    @endif
@endsection
