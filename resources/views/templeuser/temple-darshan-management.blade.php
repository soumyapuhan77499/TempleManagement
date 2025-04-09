@extends('templeuser.layouts.app')

@section('styles')
    <!-- Add any custom styles here if needed -->
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Darshan Management</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <a href="{{ route('templeuser.ManageDarshanManagement') }}" class="breadcrumb-item tx-15 btn btn-warning">Manage Darshan</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Darshan</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-body pt-0 pt-4">
                    <form method="POST" action="{{ route('templeuser.saveDarshanManagement') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Darshan Name -->
                            <div class="col-md-4 mb-3">
                                <label for="darshan_name" class="form-label">Darshan Name</label>
                                <input type="text" name="darshan_name" id="darshan_name" class="form-control"
                                    placeholder="Enter Darshan Name" required>
                            </div>
                    
                            <!-- Darshan Type -->
                            <div class="col-md-4 mb-3">
                                <label for="darshan_type" class="form-label">Darshan Type</label>
                                <select name="darshan_type" id="darshan_type" class="form-control" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="special">Special</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>
                    
                            <!-- Date (shown only if "special" is selected) -->
                            <div class="col-md-4 mb-3" id="darshan_date_container">
                                <label for="darshan_date" class="form-label">Darshan Date</label>
                                <input type="date" name="darshan_date" id="darshan_date" class="form-control">
                            </div>
                    
                            <!-- Start Time -->
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="form-control">
                            </div>
                    
                            <!-- End Time -->
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="form-control">
                            </div>
                    
                            <!-- Duration -->
                            <div class="col-md-4 mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" name="duration" id="duration" class="form-control" placeholder="Auto calculated"
                                 readonly>
                            </div>
                    
                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="2"
                                    placeholder="Enter Darshan Description"></textarea>
                            </div>
                    
                            <!-- Submit Button -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Save Darshan</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // SweetAlert logic
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
    @elseif(session('error'))
        Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
    @endif

    // Duration Calculation
    document.addEventListener('DOMContentLoaded', function () {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const durationInput = document.getElementById('duration');
        const darshanType = document.getElementById('darshan_type');
        const dateContainer = document.getElementById('darshan_date_container');
        const dateInput = document.getElementById('darshan_date');

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
                if (minutes > 0 || hours === 0) durationText += minutes + (minutes === 1 ? ' minute' : ' minutes');

                durationInput.value = durationText.trim();
            }
        }

        function toggleDateField() {
            if (darshanType.value === 'special') {
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
        darshanType.addEventListener('change', toggleDateField);

        toggleDateField(); // initialize on load
    });
</script>
@endsection

