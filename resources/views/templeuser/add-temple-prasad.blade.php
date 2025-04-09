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
                            <div class="col-md-4">
                                <label for="prasad_name" class="form-label">Prasad Name</label>
                                <input type="text" class="form-control" name="prasad_name" required>
                            </div>

                            <div class="col-md-4">
                                <label for="prasad_type" class="form-label">Prasad Type</label>
                                <select name="prasad_type" id="prasad_type" class="form-control" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="special">Special</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>

                            <div class="col-md-4" id="prasad_date_container">
                                <label for="darshan_date" class="form-label">Prasad Date</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" >
                            </div>

                            <!-- End Time -->
                            <div class="col-md-4">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" >
                            </div>

                            <!-- Duration -->
                            <div class="col-md-4">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" name="duration" id="duration" class="form-control"
                                    placeholder="Auto calculated" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="prasad_price"  class="form-label">Full Prasad Price <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prasad_price"
                                    placeholder="Enter Full Prasad Price" required>
                            </div>
                        </div>

                        <!-- Prasad Items Section -->
                        <div id="prasadItemContainer">
                            <div class="row prasad-item align-items-end">
                                <div class="col-md-5">
                                    <label for="prasad_item"  class="form-label">Prasad Item <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="prasad_item[]"
                                        placeholder="Enter Prasad Item" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button"
                                        class="btn btn-success addMore"><b>+</b></button>
                                </div>
                            </div>
                        </div>

                        <!-- Order Options -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="online_order"
                                        id="onlineOrderCheckbox">
                                    <label class="form-check-label" for="onlineOrderCheckbox">Does your Temple Provide
                                        Online Order?</label>
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
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
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
                } else if (event.target.classList.contains("remove")) {
                    event.preventDefault();
                    event.target.closest(".prasad-item").remove();
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert logic
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}'
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}'
            });
        @endif

        // Duration Calculation
        document.addEventListener('DOMContentLoaded', function() {
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const durationInput = document.getElementById('duration');
            const prasadType = document.getElementById('prasad_type');
            const dateContainer = document.getElementById('prasad_date_container');
            const dateInput = document.getElementById('date');

            function calculateDuration() {
                const start = startTimeInput.value;
                const end = endTimeInput.value;

                if (start && end) {
                    const [startHour, startMinute] = start.split(':').map(Number);
                    const [endHour, endMinute] = end.split(':').map(Number);

                    const startDate = new Date();
                    startDate.setHours(startHour, startMinute, 0);

                    const endDate = new Date();
                    endDate.setHours(endHour, endMinute, 0);

                    let diffMinutes = (endDate - startDate) / (1000 * 60);
                    if (diffMinutes < 0) diffMinutes += 1440;

                    const hours = Math.floor(diffMinutes / 60);
                    const minutes = Math.round(diffMinutes % 60);

                    let durationText = '';
                    if (hours > 0) durationText += hours + (hours === 1 ? ' hour ' : ' hours ');
                    if (minutes > 0 || hours === 0) durationText += minutes + (minutes === 1 ? ' minute' :
                        ' minutes');

                    durationInput.value = durationText.trim();
                }
            }

            function toggleDateField() {
                if (prasadType.value === 'special') {
                    dateContainer.style.display = 'block';
                    dateInput.setAttribute('required', 'required');
                } else {
                    dateContainer.style.display = 'none';
                    dateInput.removeAttribute('required');
                    dateInput.value = '';
                }
            }

            startTimeInput.addEventListener('change', calculateDuration);
            endTimeInput.addEventListener('change', calculateDuration);
            prasadType.addEventListener('change', toggleDateField);

            toggleDateField(); // initialize on load
        });
    </script>
@endsection
