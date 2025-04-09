@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .d-none {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD NEAR BY PLACES</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15">
                    <a href="{{ route('manageNearByTemple') }}" class="btn btn-warning text-white">Manage Places</a>
                </li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('saveNearByTemple') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">

                            <!-- Basic Fields -->
                            <div class="col-md-3">
                                <label for="place_type">Place Type</label>
                                <select class="form-control" id="place_type" name="place_type" required>
                                    <option value="">Select Place Type</option>
                                    <option value="temple">Temple</option>
                                    <option value="matha">Matha</option>
                                    <option value="ritual_site">Ritual Site</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="col-md-3">
                                <label for="cover_photo">Cover Photo</label>
                                <input type="file" class="form-control" id="cover_photo" name="cover_photo">
                            </div>

                            <div class="col-md-3">
                                <label for="photo">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo[]" multiple>
                            </div>

                            <div class="col-md-3">
                                <label for="map_photo">Photo</label>
                                <input type="file" class="form-control" id="map_photo" name="map_photo">
                            </div>

                            <div class="col-md-3">
                                <label for="google_map_link">Google Map Link</label>
                                <input type="url" class="form-control" id="google_map_link" name="google_map_link">
                            </div>
                         
                            <div class="col-md-3">
                                <label for="contact_no">Contact Number</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                            </div>

                            <div class="col-md-3">
                                <label for="whatsapp_no">WhatsApp Number</label>
                                <input type="text" class="form-control" id="whatsapp_no" name="whatsapp_no">
                            </div>

                            <div class="col-md-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <!-- Conditionally Displayed Fields -->
                            <div class="temple-matha-fields d-none row g-3">

                                <div class="col-12">
                                    <h5 class="text-primary">Temple Information</h5>
                                </div>

                                <div class="col-md-3">
                                    <label for="estd_date">Established Date</label>
                                    <input type="date" class="form-control" id="estd_date" name="estd_date">
                                </div>

                                <div class="col-md-3">
                                    <label for="estd_by">Established By</label>
                                    <input type="text" class="form-control" id="estd_by" name="estd_by">
                                </div>

                                <div class="col-md-3">
                                    <label for="committee_name">Committee Name</label>
                                    <input type="text" class="form-control" id="committee_name" name="committee_name">
                                </div>

                                <div class="col-md-3">
                                    <label for="priest_name">Priest Name</label>
                                    <input type="text" class="form-control" id="priest_name" name="priest_name">
                                </div>

                                <div class="col-md-3">
                                    <label for="priest_contact_no">Priest Contact Number</label>
                                    <input type="text" class="form-control" id="priest_contact_no"
                                        name="priest_contact_no">
                                </div>

                                <div class="col-md-3">
                                    <label for="distance_from_temple">Distance From Main Temple</label>
                                    <input type="text" class="form-control" id="distance_from_temple"
                                        name="distance_from_temple">
                                </div>

                                <div class="col-md-3">
                                    <label for="area_type">Temple Type</label>
                                    <select class="form-control" id="area_type" name="area_type">
                                        <option value="">Select Type</option>
                                        <option value="worldwide">Worldwide</option>
                                        <option value="inside_india">Inside India</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="history">Temple History</label>
                                    <textarea class="form-control" id="history" name="history" rows="2"></textarea>
                                </div>
                            </div>

                            <!-- Location Fields -->
                            <div class="col-md-3">
                                <label for="landmark">Landmark</label>
                                <input type="text" class="form-control" id="landmark" name="landmark">
                            </div>

                            <div class="col-md-3">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode">
                            </div>

                            <div class="col-md-3">
                                <label for="city_village">City/Village</label>
                                <input type="text" class="form-control" id="city_village" name="city_village">
                            </div>

                            <div class="col-md-3">
                                <label for="district">District</label>
                                <input type="text" class="form-control" id="district" name="district">
                            </div>

                            <div class="col-md-3">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>

                            <div class="col-md-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state">
                            </div>

                            <div class="col-md-12">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
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

    {{-- <!-- Load JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch and Populate Country Dropdown
            fetch("{{ route('get.countries') }}")
                .then(response => response.json())
                .then(data => {
                    let countryDropdown = document.getElementById("country");
                    countryDropdown.innerHTML = '<option value="">Select Country</option>';
                    data.forEach(country => {
                        let option = document.createElement("option");
                        option.value = country.id; // Use country ID
                        option.textContent = country.name;
                        countryDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching countries:", error));

            // Fetch and Populate State Dropdown based on Selected Country
            document.getElementById("country").addEventListener("change", function() {
                let countryId = this.value;
                let stateDropdown = document.getElementById("state");
                stateDropdown.innerHTML = '<option value="">Select State</option>'; // Reset

                if (countryId) {
                    fetch(`{{ url('/get-states') }}/${countryId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(state => {
                                let option = document.createElement("option");
                                option.value = state.id;
                                option.textContent = state.name;
                                stateDropdown.appendChild(option);
                            });
                        })
                        .catch(error => console.error("Error fetching states:", error));
                }
            });
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const placeTypeSelect = document.getElementById('place_type');
            const conditionalFields = document.querySelector('.temple-matha-fields');

            function toggleFields() {
                const selected = placeTypeSelect.value;
                if (selected === 'temple' || selected === 'matha') {
                    conditionalFields.classList.remove('d-none');
                } else {
                    conditionalFields.classList.add('d-none');
                    // Optional: clear the values if hidden
                    conditionalFields.querySelectorAll('input, select').forEach(input => {
                        input.value = '';
                    });
                }
            }

            toggleFields(); // Initial
            placeTypeSelect.addEventListener('change', toggleFields);
        });
    </script>
@endsection
