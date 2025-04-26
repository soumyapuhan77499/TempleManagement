@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        #specialNitiFields {
            gap: 1rem;
            flex-wrap: wrap;
        }
    </style>
    
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{ isset($niti_master) ? 'EDIT NITI' : 'ADD NITI' }}</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-niti') }}"
                        class="btn btn-warning text-dark">Manage Niti</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">
                    {{ isset($niti_master) ? 'EDIT NITI' : 'ADD NITI' }}</li>
            </ol>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" id="Message">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">

                    <form action="{{ isset($niti) ? route('updateNitiMaster', $niti->id) : route('saveNitiMaster') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($niti))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="card-title mb-1">NITI DETAILS</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Language -->
                                            <div class="col-md-2">
                                                <label class="form-label">Language</label>
                                                <select class="form-control" name="language">
                                                    <option value="">Select language...</option>
                                                    @foreach (['English', 'Hindi', 'Odia'] as $lang)
                                                        <option value="{{ $lang }}"
                                                            {{ old('language', $niti->language ?? '') == $lang ? 'selected' : '' }}>
                                                            {{ $lang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                        
                                            <!-- Niti Name -->
                                            <div class="col-md-3">
                                                <label class="form-label">Niti Name</label>
                                                <input type="text" class="form-control" name="niti_name"
                                                    value="{{ old('niti_name', $niti->niti_name ?? '') }}"
                                                    placeholder="Enter Niti Name">
                                            </div>
                        
                                            <!-- Niti Type -->
                                            <div class="col-md-4 d-flex align-items-end gap-4">
                                                @php $type = old('niti_type', $niti->niti_type ?? '') @endphp
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="niti_type"
                                                        value="special" id="nitiTypeSpecial"
                                                        {{ $type == 'special' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="nitiTypeSpecial">Special Niti</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="niti_type"
                                                        value="daily" id="nitiTypeDaily"
                                                        {{ $type == 'daily' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="nitiTypeDaily">Daily Niti</label>
                                                </div>
                                            </div>
                        
                                            <!-- Privacy -->
                                            <div class="col-md-3 d-flex align-items-end gap-4">
                                                @php $privacy = old('niti_privacy', $niti->niti_privacy ?? 'public') @endphp
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="niti_privacy"
                                                        value="public" id="publicNiti"
                                                        {{ $privacy == 'public' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="publicNiti">Public</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="niti_privacy"
                                                        value="private" id="privateNiti"
                                                        {{ $privacy == 'private' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="privateNiti">Private</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="main-content-label">Niti Order</label>
                                                    <input type="number" class="form-control" id="niti_order" name="niti_order"  value="{{ old('niti_order', $niti->niti_order ?? '') }}" placeholder="Enter Niti Order">
                                                </div>
                                            </div>
                
                                            <!-- Special Niti Fields -->
                                            <div class="col-12" id="specialNitiFields" style="display: none;">
                                                <div class="row g-3">
                                                    <!-- Date & Time -->
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date & Time</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="typcn typcn-calendar-outline"></i></span>
                                                            <input type="text" class="form-control" name="date_time"
                                                                value="{{ old('date_time', $niti->date_time ?? '') }}">
                                                        </div>
                                                    </div>
                        
                                                    <!-- After Special Niti -->
                                                    <div class="col-md-6">
                                                        <label class="form-label">Which Niti After Special Niti</label>
                                                        <select class="form-control select2" name="after_special_niti">
                                                            <option value="">Select Daily Niti</option>
                                                            @foreach ($daily_nitis as $nitiOption)
                                                                <option value="{{ $nitiOption->niti_id }}"
                                                                    {{ old('after_special_niti', $niti->after_special_niti ?? '') == $nitiOption->niti_id ? 'selected' : '' }}>
                                                                    {{ $nitiOption->niti_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- About -->
                                            <div class="col-12">
                                                <label class="form-label">Niti About</label>
                                                <textarea class="form-control" name="niti_about" rows="2"
                                                    placeholder="Enter Niti About">{{ old('niti_about', $niti->niti_about ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sub Niti -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title mb-1">SUB NITI</h4>
                            </div>
                            <div class="card-body sub-niti-container">
                                @forelse ($subNitis as $index => $subNiti)
                                    <div class="row sub-niti-row align-items-center mb-3">
                                        <div class="col-md-10">
                                            <label class="form-label">Sub Niti Name</label>
                                            <input type="text" class="form-control" name="sub_niti_name[]"
                                                value="{{ $subNiti->sub_niti_name }}">
                                        </div>
                                        <div class="col-md-2 mt-4 d-flex align-items-center">
                                            <button type="button" class="btn btn-success add-sub-niti me-2">Add</button>
                                            <button type="button" class="btn btn-danger remove-sub-niti"
                                                {{ $index == 0 ? 'style=display:none;' : '' }}>Remove</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row sub-niti-row align-items-center mb-3">
                                        <div class="col-md-10">
                                            <label class="form-label">Sub Niti Name</label>
                                            <input type="text" class="form-control" name="sub_niti_name[]"
                                                placeholder="Enter Sub Niti Name">
                                        </div>
                                        <div class="col-md-2 mt-4 d-flex align-items-center">
                                            <button type="button" class="btn btn-success add-sub-niti me-2">Add</button>
                                            <button type="button" class="btn btn-danger remove-sub-niti" style="{{ $loop->first && count($subNitis) <= 1 ? 'display:none;' : '' }}">Remove</button>
                                            
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Connect Darshan & Mahaprasad -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title mb-1">CONNECT DARSHAN AND MAHAPRASAD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Link Mahaprasad</label>
                                        <select class="form-control select2" name="connected_mahaprasad_id">
                                            <option value="">Select Mahaprasad</option>
                                            @foreach ($mahaprasads as $prasad)
                                                <option value="{{ $prasad->id }}"
                                                    {{ old('connected_mahaprasad_id', $niti->connected_mahaprasad_id ?? '') == $prasad->id ? 'selected' : '' }}>
                                                    {{ $prasad->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Link Darshan</label>
                                        <select class="form-control select2" name="connected_darshan_id">
                                            <option value="">Select Darshan</option>
                                            @foreach ($darshans as $darshan)
                                                <option value="{{ $darshan->id }}"
                                                    {{ old('connected_darshan_id', $niti->connected_darshan_id ?? '') == $darshan->id ? 'selected' : '' }}>
                                                    {{ $darshan->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter Niti Description">{{ old('description', $niti_master->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12 text-center mb-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ isset($niti) ? 'Update Niti' : 'Save Niti' }}
                                </button>
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
  

<script>
    function toggleSpecialNitiFields() {
        const specialCheckbox = document.querySelector('input[name="niti_type"][value="special"]');
        const specialFields = document.getElementById('specialNitiFields');

        if (specialCheckbox.checked) {
            specialFields.style.display = 'flex';
        } else {
            specialFields.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('input[name="niti_type"]');

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                // Uncheck the other checkbox
                checkboxes.forEach((cb) => {
                    if (cb !== this) cb.checked = false;
                });

                // Handle visibility of special fields
                toggleSpecialNitiFields();
            });
        });

        toggleSpecialNitiFields(); // Initial check on page load
    });
</script>

<script>
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-sub-niti')) {
            const container = document.querySelector('.sub-niti-container');
            const lastRow = container.querySelector('.sub-niti-row:last-of-type');
            const newRow = lastRow.cloneNode(true);

            // Clear the input value
            newRow.querySelector('input').value = '';

            // Remove add button from old rows
            container.querySelectorAll('.add-sub-niti').forEach(btn => btn.style.display = 'none');

            // Show remove button in the cloned row
            newRow.querySelector('.remove-sub-niti').style.display = 'inline-block';

            // Add button only to the last (new) row
            newRow.querySelector('.add-sub-niti').style.display = 'inline-block';

            container.appendChild(newRow);
        }

        if (event.target.classList.contains('remove-sub-niti')) {
            const row = event.target.closest('.sub-niti-row');
            row.remove();

            // Ensure only the last row shows the add button
            const allRows = document.querySelectorAll('.sub-niti-row');
            if (allRows.length) {
                allRows.forEach((r, i) => {
                    r.querySelector('.add-sub-niti').style.display = i === allRows.length - 1 ? 'inline-block' : 'none';
                    r.querySelector('.remove-sub-niti').style.display = allRows.length === 1 ? 'none' : 'inline-block';
                });
            }
        }
    });
</script>


@endsection
