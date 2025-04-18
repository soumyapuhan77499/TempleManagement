@extends('templeuser.layouts.app')

@section('styles')
    <!-- Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Public Service</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-service') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Services</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive  export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>Service Type</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Address</th>
                                    <th>Contact No.</th>
                                    <th>Whatsapp No.</th>
                                    <th>Email</th>
                                    <th>Opening Time</th>
                                    <th>Closing Time</th>
                                    <th>Google Map Link</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $index => $service)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $service->service_type }}</td>
                                        <td>{{ $service->service_name }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#photoModal{{ $service->id }}">View</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addressModal{{ $service->id }}">
                                                View Address
                                            </button>
                                            <div class="modal fade" id="addressModal{{ $service->id }}" tabindex="-1"
                                                aria-labelledby="addressModalLabel{{ $service->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Service Address</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>City/Village:</strong> {{ $service->city_village }}
                                                            </p>
                                                            <p><strong>Landmark:</strong> {{ $service->landmark }}</p>
                                                            <p><strong>Pincode:</strong> {{ $service->pincode }}</p>
                                                            <p><strong>District:</strong> {{ $service->district }}</p>
                                                            <p><strong>State:</strong> {{ $service->state }}</p>
                                                            <p><strong>Country:</strong> {{ $service->country }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $service->contact_no }}</td>
                                        <td>{{ $service->whatsapp_no }}</td>
                                        <td>{{ $service->email }}</td>
                                        <td>{{ $service->opening_time }}</td>
                                        <td>{{ $service->closing_time }}</td>
                                        <td>
                                            <a href="{{ $service->google_map_link }}" target="_blank"
                                                class="btn btn-info btn-sm">View Map</a>
                                        </td>

                                        <td>{{ $service->description }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $service->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            |
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm"
                                                data-id="{{ $service->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Photo Modal -->
                                    <div class="modal fade" id="photoModal{{ $service->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Service Photos</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $photos = json_decode($service->photo, true);
                                                    @endphp

                                                    @if (!empty($photos) && is_array($photos))
                                                        @foreach ($photos as $photo)
                                                            <img src="{{ asset($photo) }}" class="img-fluid mb-2"
                                                                style="max-width: 100%;">
                                                        @endforeach
                                                    @else
                                                        <p>No photos available</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Service Modal -->
                                    <div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $service->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Emergency</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('updateService', $service->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="service_type">Service Type</label>
                                                                    <select class="form-control" id="service_type"
                                                                        name="service_type" required>
                                                                        <option value="locker"
                                                                            {{ $service->service_type == 'locker' ? 'selected' : '' }}>
                                                                            Locker</option>
                                                                        <option value="shoe_stand"
                                                                            {{ $service->service_type == 'shoe_stand' ? 'selected' : '' }}>
                                                                            Shoe Stand</option>
                                                                        <option value="drinking_water"
                                                                            {{ $service->service_type == 'drinking_water' ? 'selected' : '' }}>
                                                                            Drinking Water</option>
                                                                        <option value="free_food"
                                                                            {{ $service->service_type == 'free_food' ? 'selected' : '' }}>
                                                                            Free Food</option>
                                                                        <option value="ratha_yatra_mela"
                                                                            {{ $service->service_type == 'ratha_yatra_mela' ? 'selected' : '' }}>
                                                                            Ratha Yatra Mela</option>
                                                                        <option value="beach"
                                                                            {{ $service->service_type == 'beach' ? 'selected' : '' }}>
                                                                            Beach</option>
                                                                        <option value="life_guard_booth"
                                                                            {{ $service->service_type == 'life_guard_booth' ? 'selected' : '' }}>
                                                                            Life Guard Booth</option>
                                                                        <option value="charging_station"
                                                                            {{ $service->service_type == 'charging_station' ? 'selected' : '' }}>
                                                                            Charging Station</option>
                                                                        <option value="petrol_pump"
                                                                            {{ $service->service_type == 'petrol_pump' ? 'selected' : '' }}>
                                                                            Petrol Pump</option>
                                                                        <option value="atm"
                                                                            {{ $service->service_type == 'atm' ? 'selected' : '' }}>
                                                                            ATM</option>
                                                                        <option value="lost_and_found_booth"
                                                                            {{ $service->service_type == 'lost_and_found_booth' ? 'selected' : '' }}>
                                                                            Lost and Found Booth</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="service_name">Service Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="service_name" name="service_name"
                                                                        value="{{ $service->service_name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="photos">Photos</label>
                                                                    <input type="file" class="form-control"
                                                                        id="photo" name="photo[]" multiple>
                                                                    @if ($service->photos)
                                                                        <div class="mt-2">
                                                                            @foreach (json_decode($service->photos) as $photo)
                                                                                <img src="{{ asset('uploads/service_photos/' . $photo) }}"
                                                                                    width="50" height="50"
                                                                                    class="me-2">
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="opening_time">Opening Time</label>
                                                                    <input type="time" class="form-control"
                                                                        id="opening_time" name="opening_time"
                                                                        value="{{ $service->opening_time }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="closing_time">Closing Time</label>
                                                                    <input type="time" class="form-control"
                                                                        id="closing_time" name="closing_time"
                                                                        value="{{ $service->closing_time }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="contact_no">Contact No</label>
                                                                    <input type="text" class="form-control"
                                                                        id="contact_no" name="contact_no"
                                                                        value="{{ $service->contact_no }}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="whatsapp_no">WhatsApp No</label>
                                                                    <input type="text" class="form-control"
                                                                        id="whatsapp_no" name="whatsapp_no"
                                                                        value="{{ $service->whatsapp_no }}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="email" name="email"
                                                                        value="{{ $service->email }}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="google_map_link">Google Map Link</label>
                                                                    <input type="url" class="form-control"
                                                                        id="google_map_link" name="google_map_link"
                                                                        value="{{ $service->google_map_link }}" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Address -->
                                                        <h5 class="mt-4 mb-3">Address</h5>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="landmark">Landmark</label>
                                                                    <input type="text" class="form-control"
                                                                        id="landmark" name="landmark"
                                                                        value="{{ $service->landmark }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="pincode">Pincode</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pincode" name="pincode"
                                                                        value="{{ $service->pincode }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="city_village">City/Village</label>
                                                                    <input type="text" class="form-control"
                                                                        id="city_village" name="city_village"
                                                                        value="{{ $service->city_village }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="district">District</label>
                                                                    <input type="text" class="form-control"
                                                                        id="district" name="district"
                                                                        value="{{ $service->district }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="state">State</label>
                                                                    <select class="form-control" id="state"
                                                                        name="state">
                                                                        <option value="Odisha"
                                                                            {{ $service->state == 'Odisha' ? 'selected' : '' }}>
                                                                            Odisha</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="country">Country</label>
                                                                    <select class="form-control" id="country"
                                                                        name="country">
                                                                        <option value="India"
                                                                            {{ $service->country == 'India' ? 'selected' : '' }}>
                                                                            India</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $service->description }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@section('scripts')
    <!-- Internal Data tables -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/table-data.js') }}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.closest('.delete-confirm')) {
                    let serviceId = event.target.closest('.delete-confirm').getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Service as deleted but won't permanently remove it.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/templeuser/delete-service/${serviceId}`;
                        }
                    });
                }
            });
        });
    </script>


    <script>
        function showFullImage(imageSrc) {
            Swal.fire({
                imageUrl: imageSrc,
                imageAlt: 'Matha Photo',
                showCloseButton: true,
                showConfirmButton: false,
            });
        }
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