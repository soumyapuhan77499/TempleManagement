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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Prasad</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-temple-prasad') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Prasad</a>
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
                                    <th>Prasad Name</th>
                                    <th>Time</th>
                                    <th>Price</th>
                                    <th>Items</th>
                                    <th>Online Order</th>
                                    <th>Offline Order</th>
                                    <th>Pre Order</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prasadas as $index => $prasad)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $prasad->prasad_name }}</td>
                                        <td>{{ $prasad->prasad_time }}</td>
                                        <td>₹{{ number_format($prasad->prasad_price, 2) }}</td>

                                        <!-- Display prasad items as badges -->
                                        <td>
                                            @foreach (explode(',', $prasad->prasad_item) as $item)
                                                <span class="badge bg-primary">{{ $item }}</span>
                                            @endforeach
                                        </td>

                                        <!-- Display order availability -->
                                        <td>
                                            <span class="badge {{ $prasad->online_order ? 'bg-success' : 'bg-danger' }}">
                                                {{ $prasad->online_order ? 'Available' : 'Not Available' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $prasad->offline_order ? 'bg-success' : 'bg-danger' }}">
                                                {{ $prasad->offline_order ? 'Available' : 'Not Available' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $prasad->pre_order ? 'bg-success' : 'bg-danger' }}">
                                                {{ $prasad->pre_order ? 'Available' : 'Not Available' }}
                                            </span>
                                        </td>

                                        <td>{{ $prasad->description }}</td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $prasad->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            |
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm"
                                                data-id="{{ $prasad->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $prasad->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $prasad->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Prasad</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('templeprasad.update', $prasad->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">

                                                        <!-- Prasad Name, Time & Price -->
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="prasad_name">Prasad Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="prasad_name"
                                                                        value="{{ $prasad->prasad_name }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="prasad_time">Prasad Time</label>
                                                                    <input type="time" class="form-control"
                                                                        name="prasad_time"
                                                                        value="{{ $prasad->prasad_time }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="prasad_price">Full Prasad Price <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        name="prasad_price"
                                                                        value="{{ $prasad->prasad_price }}"
                                                                        placeholder="Enter Full Prasad Price" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Prasad Items Section -->
                                                        <div id="prasadItemContainer">
                                                            @foreach (explode(',', $prasad->prasad_item) as $item)
                                                                <div class="row prasad-item align-items-end">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label for="prasad_item">Prasad Item <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                name="prasad_item[]"
                                                                                value="{{ trim($item) }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-danger removeItem"  style="margin-bottom: 15px"><b>-</b></button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <button type="button"
                                                                        class="btn btn-success addMore"><b>+</b> Add
                                                                        More</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Order Options -->
                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="online_order" id="onlineOrderCheckbox"
                                                                        {{ $prasad->online_order ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="onlineOrderCheckbox">Does your Temple Provide
                                                                        Online Order?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="pre_order"
                                                                        {{ $prasad->pre_order ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Does your Temple
                                                                        Provide Pre Order?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="offline_order"
                                                                        {{ $prasad->offline_order ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Does your Temple
                                                                        Provide Offline Order?</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Description -->
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="description">Description</label>
                                                                    <textarea class="form-control" name="description" placeholder="Enter description">{{ $prasad->description }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- Modal Footer -->
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
                    let PrasadId = event.target.closest('.delete-confirm').getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Prasad as deleted but won't permanently remove it.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/delete-temple-prasad/${PrasadId}`;
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

	<script>
		$(document).ready(function () {
    // Add more Prasad items
    $(".addMore").click(function () {
        let newItem = `
            <div class="row prasad-item align-items-end">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="prasad_item">Prasad Item <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="prasad_item[]" placeholder="Enter Prasad Item" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger removeItem"  style="margin-bottom: 15px"><b>-</b></button>
                </div>
            </div>
        `;
        $("#prasadItemContainer").append(newItem);
    });

    // Remove Prasad items
    $(document).on("click", ".removeItem", function () {
        $(this).closest(".prasad-item").remove();
    });
});

	</script>
@endsection
