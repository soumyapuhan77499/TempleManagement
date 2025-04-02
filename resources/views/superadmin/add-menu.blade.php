@extends('superadmin.layouts.app')


@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Menu</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">

                <li class="breadcrumb-item tx-15">
                    <div class="text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mainMenuModal">
                            Add Main Menu
                        </button>
                    </div>
                </li>

                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fa fa-list-alt me-2"></i>Add Sub Menu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('saveSubMenu') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-3">

                            <!-- Menu Type -->
                            <div class="col-md-4">
                                <label for="menu_type" class="form-label">
                                    <i class="fa fa-bars me-1"></i>Menu Type
                                </label>
                                <select class="form-select" id="menu_type" name="menu_type" required>
                                    <option value="sidebar">Sidebar</option>
                                    <option value="header">Header</option>
                                </select>
                            </div>

                            <!-- Sidebar-Only Fields -->
                            <div class="sidebar-only col-md-4">
                                <label for="menu_id" class="form-label">
                                    <i class="fa fa-stream me-1"></i>Main Menu
                                </label>
                                <select class="form-select" id="menu_id" name="menu_id">
                                    <option value="">Select Main Menu</option>
                                    @foreach ($mainMenus as $mainMenu)
                                        <option value="{{ $mainMenu->id }}">{{ $mainMenu->menu_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sidebar-only col-md-4">
                                <label for="sub_menu_name" class="form-label">
                                    <i class="fa fa-pencil-alt me-1"></i>Sub Menu Name
                                </label>
                                <input type="text" class="form-control" id="sub_menu_name" name="sub_menu_name"
                                    placeholder="Enter Sub Menu Name">
                            </div>

                            <div class="sidebar-only col-md-4">
                                <label for="icon_type" class="form-label">
                                    <i class="fa fa-image me-1"></i>Icon Type
                                </label>
                                <select class="form-select" id="icon_type" name="icon_type">
                                    <option value="icon">Icon</option>
                                    <option value="photo">Icon Photo</option>
                                </select>
                            </div>

                            <div class="sidebar-only col-md-4 icon-input">
                                <label for="icon" class="form-label">
                                    <i class="fa fa-font-awesome me-1"></i>Icon Class
                                </label>
                                <input type="text" class="form-control" id="icon" name="icon"
                                    placeholder="e.g. fa fa-home">
                            </div>

                            <div class="sidebar-only col-md-4 icon-photo d-none">
                                <label for="icon_photo" class="form-label">
                                    <i class="fa fa-upload me-1"></i>Icon Photo
                                </label>
                                <input type="file" class="form-control" id="icon_photo" name="icon_photo"
                                    accept="image/*">
                            </div>

                            <!-- Common Fields -->
                            <div class="col-md-4">
                                <label for="url_type" class="form-label">
                                    <i class="fa fa-link me-1"></i>URL Type
                                </label>
                                <select class="form-select" id="url_type" name="url_type">
                                    <option value="route">Route</option>
                                    <option value="url">URL</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="menu_url" class="form-label">
                                    <i class="fa fa-external-link-alt me-1"></i>Menu URL
                                </label>
                                <input type="text" class="form-control" id="menu_url" name="menu_url"
                                    placeholder="Enter Menu URL or route name">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i>Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Menu Modal -->
    <div class="modal fade" id="mainMenuModal" tabindex="-1" aria-labelledby="mainMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 rounded-2 shadow-sm">
                <form action="{{ route('saveMainMenu') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="mainMenuModalLabel">
                            <i class="fa fa-plus-circle me-2"></i>Add Main Menu
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row gy-3">
                            <!-- Menu Name -->
                            <div class="col-md-6">
                                <label for="menu_name" class="form-label">
                                    <i class="fa fa-edit me-1"></i>Menu Name
                                </label>
                                <input type="text" class="form-control" id="menu_name" name="menu_name"
                                    placeholder="Enter menu name" required>
                            </div>

                            <!-- Icon Class -->
                            <div class="col-md-6">
                                <label for="menu_icon" class="form-label">
                                    <i class="fa fa-icons me-1"></i>Icon Class (e.g., fa fa-home)
                                </label>
                                <input type="text" class="form-control" id="menu_icon" name="menu_icon"
                                    placeholder="Enter icon class">
                            </div>

                            <!-- URL Type -->
                            <div class="col-md-6">
                                <label for="url_type" class="form-label">
                                    <i class="fa fa-link me-1"></i>URL Type
                                </label>
                                <select class="form-select" id="url_type" name="url_type">
                                    <option value="route">Route</option>
                                    <option value="url">URL</option>
                                </select>
                            </div>

                            <!-- Menu URL / Route -->
                            <div class="col-md-6">
                                <label for="menu_url" class="form-label">
                                    <i class="fa fa-external-link-alt me-1"></i>Menu URL / Route
                                </label>
                                <input type="text" class="form-control" id="menu_url" name="menu_url"
                                    placeholder="Enter route name or full URL">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between px-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i>Save Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuTypeSelect = document.getElementById('menu_type');
            const sidebarFields = document.querySelectorAll('.sidebar-only');
            const iconTypeSelect = document.getElementById('icon_type');
            const iconInput = document.querySelector('.icon-input');
            const iconPhoto = document.querySelector('.icon-photo');
    
            function toggleMenuFields() {
                const isSidebar = menuTypeSelect.value === 'sidebar';
                sidebarFields.forEach(field => {
                    field.style.display = isSidebar ? 'block' : 'none';
                });
            }
    
            function toggleIconFields() {
                const isIcon = iconTypeSelect.value === 'icon';
                iconInput.classList.toggle('d-none', !isIcon);
                iconPhoto.classList.toggle('d-none', isIcon);
            }
    
            // Initial toggle
            toggleMenuFields();
            toggleIconFields();
    
            // Event listeners
            menuTypeSelect.addEventListener('change', toggleMenuFields);
            iconTypeSelect.addEventListener('change', toggleIconFields);
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('#mainMenuModal form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch("{{ route('saveMainMenu') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // or close modal & refresh table
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message,
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                        console.error(err);
                    });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('#mainMenuModal form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch("{{ route('saveMainMenu') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json().then(data => ({
                        status: res.status,
                        body: data
                    })))
                    .then(res => {
                        if (res.status === 200 && res.body.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.body.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // or hide modal and refresh part of page
                            });
                        } else if (res.status === 422 && res.body.status === 'validation_error') {
                            const errorMessages = Object.values(res.body.errors).flat().join('<br>');
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validation Error',
                                html: errorMessages
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.body.message || 'An unexpected error occurred.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong while submitting the form.'
                        });
                    });
            });
        });
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('form[action="{{ route('saveSubMenu') }}"]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch("{{ route('saveSubMenu') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(async (response) => {
                const contentType = response.headers.get("content-type");
                let data = {};
                
                if (contentType && contentType.includes("application/json")) {
                    data = await response.json();
                } else {
                    throw new Error("Server returned non-JSON. Check server logs or Laravel error pages.");
                }

                if (response.ok && data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else if (response.status === 422 && data.status === 'validation_error') {
                    const errorMessages = Object.values(data.errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        html: errorMessages
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: data.message || 'Something went wrong!'
                    });
                }
            })
            .catch(error => {
                console.error('Unexpected error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Unexpected Error',
                    text: error.message || 'Something went wrong. Please try again.',
                });
            });
        });
    });
</script>


    
@endsection
