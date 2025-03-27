@extends('templeuser.layouts.app')

@section('styles')
    <!-- Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .lost-btn {
            background-color: #f44336;
            color: #fff;
        }

        .found-btn {
            background-color: #4caf50;
            color: #fff;
        }

        .modal-header {
            background-color: #f1f1f1;
        }

        .form-icon {
            margin-right: 10px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Lost and Found</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lost and Found</li>
            </ol>
        </div>
    </div>


    <button class="btn lost-btn btn-lg" style="background: linear-gradient(to right, #85c2f1, #022269);color: white"
        data-bs-toggle="modal" data-bs-target="#lostFoundModal">
        <i class="fas fa-plus"></i> Add Lost/Found Item
    </button>

    <div class="table-responsive  export-table mt-4">
        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Item</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Photo</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span
                                class="badge bg-{{ $row->type == 'lost' ? 'danger' : 'success' }}">{{ ucfirst($row->type) }}</span>
                        </td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->phone_no }}</td>
                        <td>{{ $row->item_name }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewLocationModal" data-location="{{ $row->item_location }}">
                                <i class="fa fa-map-marker-alt"></i>
                            </button>
                        </td>
                        <td><span class="badge bg-secondary">{{ ucfirst($row->status) }}</span></td>
                        <td>
                            @if ($row->item_photo)
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#viewPhotoModal"
                                    data-photo="{{ asset('storage/' . $row->item_photo) }}">
                                    <i class="fa fa-image"></i>
                                </button>
                            @endif
                        </td>
                        <td>{{ $row->description }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editLostAndFoundBtn" data-id="{{ $row->id }}"
                                data-toggle="modal" data-target="#editNijogaModal">
                                <i class="fa fa-edit"></i>
                            </button>
                            |
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm"
                                data-id="{{ $row->id }}">
                                <i class="fa fa-trash"></i>
                            </a>

                            <form id="delete-form-{{ $row->id }}"
                                action="{{ route('deleteLostAndFound', $row->id) }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>


        </table>
    </div>
    <!-- View Photo Modal -->
    <div class="modal fade" id="viewPhotoModal" tabindex="-1" aria-labelledby="viewPhotoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <h5 class="mb-3" id="viewPhotoLabel">Item Photo</h5>
                <img id="photoModalImage" src="" alt="Item Photo" class="img-fluid rounded" />
            </div>
        </div>
    </div>
    <!-- View Location Modal -->
    <div class="modal fade" id="viewLocationModal" tabindex="-1" aria-labelledby="viewLocationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <h5 class="mb-3" id="viewLocationLabel">Item Location</h5>
                <p id="locationModalText" class="fw-bold text-dark"></p>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="lostFoundModal" tabindex="-1" aria-labelledby="lostFoundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('saveLostAndFound') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="lostFoundModalLabel">
                        <i class="fas fa-info-circle"></i> Add Lost or Found Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Entry Type --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" id="entryType">
                                <option value="lost">Lost</option>
                                <option value="found">Found</option>
                            </select>
                        </div>
                    </div>

                    {{-- Common Fields --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone No</label>
                            <input type="text" name="phone_no" class="form-control" placeholder="Phone Number">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Your Address">
                        </div>
                    </div>

                    {{-- Shared Item Details --}}
                    <div id="itemFields">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" id="itemNameLabel">Item Name</label>
                                <input type="text" name="item_name" class="form-control" placeholder="Item Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" id="itemPhotoLabel">Item Photo</label>
                                <input type="file" name="item_photo" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" id="itemLocationLabel">Item Location</label>
                                <input type="text" name="item_location" class="form-control" placeholder="Location">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editLostFoundModal" tabindex="-1" aria-labelledby="editLostFoundModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editLostFoundForm" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editLostFoundModalLabel">
                        <i class="fas fa-edit"></i> Edit Lost or Found Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Type --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" id="editType">
                                <option value="lost">Lost</option>
                                <option value="found">Found</option>
                            </select>
                        </div>
                    </div>

                    {{-- Common Fields --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="editName" class="form-control"
                                placeholder="Your Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone No</label>
                            <input type="text" name="phone_no" id="editPhone" class="form-control"
                                placeholder="Phone Number">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" id="editAddress" class="form-control"
                                placeholder="Your Address">
                        </div>
                    </div>

                    {{-- Shared Item Details --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" id="editItemNameLabel">Item Name</label>
                            <input type="text" name="item_name" id="editItemName" class="form-control"
                                placeholder="Item Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Change Item Photo (optional)</label>
                            <input type="file" name="item_photo" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" id="editItemLocationLabel">Item Location</label>
                            <input type="text" name="item_location" id="editItemLocation" class="form-control"
                                placeholder="Location">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="editDescription" rows="3" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Internal Data tables -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const entryType = document.getElementById("entryType");

            const itemNameLabel = document.getElementById("itemNameLabel");
            const itemPhotoLabel = document.getElementById("itemPhotoLabel");
            const itemLocationLabel = document.getElementById("itemLocationLabel");

            entryType.addEventListener("change", function() {
                const isLost = this.value === 'lost';
                itemNameLabel.textContent = isLost ? "Lost Item Name" : "Found Item Name";
                itemPhotoLabel.textContent = isLost ? "Lost Item Photo" : "Found Item Photo";
                itemLocationLabel.textContent = isLost ? "Lost Item Location" : "Found Item Location";
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.addEventListener('click', function(event) {
                const target = event.target.closest('.delete-confirm');
                if (target) {
                    const lostfoundId = target.getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Lost and Found item as deleted, not permanently removed.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById(`delete-form-${lostfoundId}`);
                            if (form) {
                                form.submit();
                            }
                        }
                    });
                }
            });
        });
    </script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: '{{ $errors->first() }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    <script>
        const photoModal = document.getElementById('viewPhotoModal');
        photoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const photo = button.getAttribute('data-photo');
            const modalImg = document.getElementById('photoModalImage');
            modalImg.src = photo;
        });

        const locationModal = document.getElementById('viewLocationModal');
        locationModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const location = button.getAttribute('data-location');
            const locationText = document.getElementById('locationModalText');
            locationText.textContent = location;
        });
    </script>
    <script>
        document.querySelectorAll('.editLostAndFoundBtn').forEach(button => {
            button.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');

                // Get record details from server (AJAX)
                const response = await fetch(`/templeuser/lost-found/${id}`);
                const data = await response.json();

                // Populate modal fields
                document.getElementById('editType').value = data.type;
                document.getElementById('editName').value = data.name;
                document.getElementById('editPhone').value = data.phone_no;
                document.getElementById('editAddress').value = data.address;
                document.getElementById('editItemName').value = data.item_name;
                document.getElementById('editItemLocation').value = data.item_location;
                document.getElementById('editDescription').value = data.description;

                // Update item labels
                document.getElementById('editItemNameLabel').textContent = data.type === 'lost' ?
                    'Lost Item Name' : 'Found Item Name';
                document.getElementById('editItemLocationLabel').textContent = data.type === 'lost' ?
                    'Lost Item Location' : 'Found Item Location';

                // Set the form action
                document.getElementById('editLostFoundForm').action =
                    `/templeuser/update-lost-and-found/${id}`;

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('editLostFoundModal'));
                modal.show();
            });
        });
    </script>
@endsection
