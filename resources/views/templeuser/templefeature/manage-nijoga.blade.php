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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Nijoga</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-nijoga') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Njoga</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Nijoga</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->


    @if (session('success'))
        <div id = 'Message' class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('danger'))
        <div id = 'Message' class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif
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
                                    <th>Nijoga Name</th>
                                    <th>Nijoga Photo</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nijogas as $index => $nijoga)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $nijoga->nijoga_name }}</td>

                                        <td>
                                            @if ($nijoga->nijoga_photo)
                                                <button class="btn btn-primary btn-sm view-photo"
                                                    data-photo="{{ asset($nijoga->nijoga_photo) }}" data-bs-toggle="modal"
                                                    data-bs-target="#photoModal">
                                                    View Photo
                                                </button>
                                            @else
                                                No Image
                                            @endif
                                        </td>


                                        <td>{{ $nijoga->description }}</td>
                                        <td>

                                            <button class="btn btn-warning btn-sm editNijogaBtn"
                                                data-id="{{ $nijoga->id }}" data-name="{{ $nijoga->nijoga_name }}"
                                                data-description="{{ $nijoga->description }}"
                                                data-photo="{{ asset($nijoga->nijoga_photo) ?? '' }}" data-toggle="modal"
                                                data-target="#editNijogaModal">
                                                Edit
                                            </button>
                                            |
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm"
                                                data-id="{{ $nijoga->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Nijoga Photo Modal -->
                        <div class="modal fade" id="photoModal" tabindex="-1" role="dialog"
                            aria-labelledby="photoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="photoModalLabel">Nijoga Photo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="nijogaPhoto" src="" class="img-fluid" alt="Nijoga Photo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Nijoga Modal -->
                        <div class="modal fade" id="editNijogaModal" tabindex="-1" role="dialog"
                            aria-labelledby="editNijogaModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editNijogaModalLabel">Edit Nijoga</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="updateNijogaForm" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" id="edit_nijoga_id" name="id">

                                            <div class="form-group">
                                                <label for="edit_nijoga_name">Nijoga Name</label>
                                                <input type="text" class="form-control" id="edit_nijoga_name"
                                                    name="nijoga_name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="edit_description">Description</label>
                                                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="edit_nijoga_photo">Nijoga Photo Upload</label>
                                                <input type="file" class="form-control" id="edit_nijoga_photo"
                                                    name="nijoga_photo">
                                                <img id="edit_photo_preview" src="" alt="Current Photo"
                                                    width="80" class="mt-2">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    
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
                    let nijogaId = event.target.closest('.delete-confirm').getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Nijoga as deleted but won't permanently remove it.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/templeuser/delete-nijoga/${nijogaId}`;
                        }
                    });
                }
            });
        });
    </script>

<script>
    $(document).ready(function () {
        $('.editNijogaBtn').on('click', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let description = $(this).data('description');
            let photo = $(this).data('photo');

            $('#edit_nijoga_id').val(id);
            $('#edit_nijoga_name').val(name);
            $('#edit_description').val(description);
            
            if (photo) {
                $('#edit_photo_preview').attr('src', photo);
            } else {
                $('#edit_photo_preview').hide();
            }

            // Set form action dynamically
            let updateUrl = "{{ route('updateNijoga', ':id') }}";
            updateUrl = updateUrl.replace(':id', id);
            $('#updateNijogaForm').attr('action', updateUrl);
        });
    });
</script>


    <script>
        $(document).ready(function() {
            $(document).on("click", ".view-photo", function() {
                var photoSrc = $(this).data("photo");
                console.log(photoSrc); // Debugging
                $("#nijogaPhoto").attr("src", photoSrc);
            });
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
