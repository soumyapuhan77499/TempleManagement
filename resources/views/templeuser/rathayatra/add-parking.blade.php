@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="odia">Odia</option>
                                        <option value="english">English</option>
                                    </select>
                                </div>
                            </div> --}}
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="map_url">Map URL</label>
                                    <input type="text" class="form-control" id="map_url" name="map_url"
                                        placeholder="Enter URL...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking_photo">Photo</label>
                                    <input type="file" class="form-control" id="parking_photo" name="parking_photo">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="vehicle_type" class="form-label">Vehicle Type</label>
                                    <div class="d-flex ">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="two_wheeler"
                                                name="vehicle_type[]" value="two wheeler">
                                            <label class="form-check-label" for="two_wheeler">Two Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="four_wheeler"
                                                name="vehicle_type[]" value="four wheeler">
                                            <label class="form-check-label" for="four_wheeler">Four Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="three_wheeler"
                                                name="vehicle_type[]" value="three wheeler">
                                            <label class="form-check-label" for="three_wheeler">Three Wheeler</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="heavy_vehicle"
                                                name="vehicle_type[]" value="heavy vehicle">
                                            <label class="form-check-label" for="heavy_vehicle">Heavy Vehicle</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="electric_vehicle"
                                                name="vehicle_type[]" value="electric vehicle">
                                            <label class="form-check-label" for="electric_vehicle">Electric
                                                Vehicle</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <!-- Vehicle Type Section -->
                           
                            <div class="col-md-4">
                                <!-- Pass Type Section -->
                                <div class="form-group row">
                                    <label for="pass_type" class="col-sm-4 col-form-label">Who Can Park</label>
                                    <div class="col-sm-10 d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="vip"
                                                name="pass_type[]" value="vip">
                                            <label class="form-check-label" for="vip">Vip</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="vvip"
                                                name="pass_type[]" value="vvip">
                                            <label class="form-check-label" for="vvip">Vvip</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="normal"
                                                name="pass_type[]" value="normal">
                                            <label class="form-check-label" for="normal">Normal</label>
                                        </div>

                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="all"
                                                name="pass_type[]" value="sebayat">
                                            <label class="form-check-label" for="sebayat">Sebayat</label>
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
                                            <input class="form-check-input" type="checkbox" id="cover"
                                                name="area_type[]" value="cover">
                                            <label class="form-check-label" for="cover">Covered</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="open"
                                                name="area_type[]" value="open">
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
                                            <input class="form-check-input" type="checkbox" id="automated"
                                                name="parking_management[]" value="automated">
                                            <label class="form-check-label" for="automated">Automated</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="manual"
                                                name="parking_management[]" value="manual">
                                            <label class="form-check-label" for="manual">Manual</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 style="margin-bottom: 20px">ADDRESS</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="landmark">Landmark</label>
                                    <input type="text" class="form-control" id="landmark" name="landmark"
                                        placeholder="Enter landmark">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode"
                                        placeholder="Enter pincode">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_village">City/Village</label>
                                    <input type="text" class="form-control" id="city_village" name="city_village"
                                        placeholder="Enter city or village">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <input type="text" class="form-control" id="district" name="district"
                                        placeholder="Enter district">
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
    <script>
        // Fetch country data and populate dropdown
        document.addEventListener("DOMContentLoaded", function() {
            var headers = new Headers();
            headers.append("X-CSCAPI-KEY", "API_KEY"); // Replace API_KEY with your actual API key

            var requestOptions = {
                method: 'GET',
                headers: headers,
                redirect: 'follow'
            };

            fetch("https://api.countrystatecity.in/v1/countries", requestOptions)
                .then(response => response.json())
                .then(data => {
                    let countryDropdown = document.getElementById("country");

                    data.forEach(country => {
                        let option = document.createElement("option");
                        option.value = country.iso2; // Using country code as value
                        option.textContent = country.name;
                        countryDropdown.appendChild(option);
                    });
                })
                .catch(error => console.log('Error fetching countries:', error));
        });
    </script>

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
@endsection
