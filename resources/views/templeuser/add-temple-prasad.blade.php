@extends('templeuser.layouts.app')

@section('styles')
    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title">Add Prasad Details</span>
        </div>
		
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
				<li class="breadcrumb-item tx-15"><a href="{{ route('templeprasad.manageprasad') }}"
					class="btn btn-warning text-white">Manage Prasad</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <!-- Error Handling -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Start -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('templeprasad.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Prasad Name & Time & Price -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="prasad_name">Prasad Name</label>
                                    <input type="text" class="form-control" name="prasad_name" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="prasad_time">Prasad Time</label>
                                    <input type="time" class="form-control" name="prasad_time" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="prasad_photo">Prasad Photo</label>
                                    <input type="file" class="form-control" name="prasad_photo">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="prasad_price">Full Prasad Price <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="prasad_price" placeholder="Enter Full Prasad Price" required>
                                </div>
                            </div>
                        </div>

                        <!-- Prasad Items Section -->
                        <div id="prasadItemContainer">
                            <div class="row prasad-item align-items-end">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="prasad_item">Prasad Item <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="prasad_item[]" placeholder="Enter Prasad Item" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" style="margin-bottom: 15px" class="btn btn-success addMore"><b>+</b></button>
                                </div>
                            </div>
                        </div>

                        <!-- Order Options -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="online_order" id="onlineOrderCheckbox">
                                    <label class="form-check-label" for="onlineOrderCheckbox">Does your Temple Provide Online Order?</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pre_order">
                                    <label class="form-check-label">Does your Temple Provide Pre Order?</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="offline_order">
                                    <label class="form-check-label">Does your Temple Provide Offline Order?</label>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("prasadItemContainer");

        container.addEventListener("click", function(event) {
            if (event.target.classList.contains("addMore")) {
                event.preventDefault();

                let newRow = document.createElement("div");
                newRow.classList.add("row", "prasad-item", "align-items-end", "mt-2");

                newRow.innerHTML = `
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" class="form-control" name="prasad_item[]" placeholder="Enter Prasad Item" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button"  style="margin-bottom: 15px" class="btn btn-danger remove"><b>-</b></button>
                    </div>
                `;

                container.appendChild(newRow);
            } 
            else if (event.target.classList.contains("remove")) {
                event.preventDefault();
                event.target.closest(".prasad-item").remove();
            }
        });
    });
</script>
<!-- SweetAlert for Notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
        });
    </script>
@endif
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
@endif

@endsection
