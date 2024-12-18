@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-1">NITI DETAILS</h4>
                                    </div>

                                    <div class="row">
                                        <!-- Language Selection -->
                                        <div class="col-md-2">
                                            <div class="card-body">
                                                <div class="main-content-label mg-b-5">Language</div>
                                                <select class="form-control" id="language" name="language">
                                                    <option value="">Select language...</option>
                                                    <option value="English"
                                                        {{ old('language', $niti->language) == 'English' ? 'selected' : '' }}>
                                                        English</option>
                                                    <option value="Hindi"
                                                        {{ old('language', $niti->language) == 'Hindi' ? 'selected' : '' }}>
                                                        Hindi</option>
                                                    <option value="Odia"
                                                        {{ old('language', $niti->language) == 'Odia' ? 'selected' : '' }}>
                                                        Odia</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Niti Name Input -->
                                        <div class="col-md-3">
                                            <div class="card-body">
                                                <div class="main-content-label mg-b-5">Niti Name</div>
                                                <input type="text" class="form-control" id="niti_name" name="niti_name"
                                                    value="{{ old('niti_name', $niti->niti_name) }}"
                                                    placeholder="Enter Niti Name">
                                            </div>
                                        </div>

                                        <!-- Niti Type Checkbox -->
                                        <div class="col-md-4" style="margin-top: 30px">
                                            <div class="form-group row">
                                                <label class="custom-switch">
                                                    <span class="custom-switch-description tx-15  mg-b-5">Special
                                                        Niti</span>
                                                    <input type="checkbox" name="niti_type[]" value="special"
                                                        class="custom-switch-input" id="specialNiti"
                                                        {{ in_array('special_niti', old('niti_type', explode(',', $niti->niti_type))) ? 'checked' : '' }}>
                                                    <span
                                                        class="custom-switch-indicator custom-switch-indicator-xl custom-square"></span>
                                                </label>
                                                
                                                <label class="custom-switch">
                                                    <span class="custom-switch-description tx-15 me-2">Daily Niti</span>
                                                    <input type="checkbox" name="niti_type[]" value="daily"
                                                        class="custom-switch-input" id="dailyNiti"
                                                        {{ in_array('daily_niti', old('niti_type', explode(',', $niti->niti_type))) ? 'checked' : '' }}>
                                                    <span
                                                        class="custom-switch-indicator custom-switch-indicator-xl custom-square"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Date & Time -->
                                        <div class="col-md-3">
                                            <div class="card-body">
                                                <div class="main-content-label mg-b-5">Date & Time</div>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                    </div>
                                                    <input class="form-control" id="datetimepicker" name="date_time"
                                                        type="text" value="{{ old('date_time', $niti->date_time) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Niti About Textarea -->
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="main-content-label">Niti About</div>
                                                <textarea class="form-control" id="niti_about" name="niti_about" placeholder="Enter Niti About">{{ old('niti_about', $niti->niti_about) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- niti item --}}
                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-1">NITI ITEMS</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="item-container">
                                            @foreach ($nitiItems as $nitiItem)
                                                <div class="row item-row align-items-center mb-3">
                                                    <div class="col-md-4">
                                                        <div class="main-content-label mg-b-5">Item Name</div>
                                                        <input type="text" class="form-control" name="item_name[]"
                                                            value="{{ old('item_name', $nitiItem->item_name) }}"
                                                            placeholder="Enter Item Name">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="main-content-label mg-b-5">Quantity</div>
                                                        <input type="text" class="form-control" name="quantity[]"
                                                            value="{{ old('quantity', $nitiItem->quantity) }}"
                                                            placeholder="Enter Quantity">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="main-content-label mg-b-5">Unit</div>
                                                        <select class="form-control" name="unit[]">
                                                            <option value="">Select Unit</option>
                                                            <option value="kg"
                                                                {{ $nitiItem->unit == 'kg' ? 'selected' : '' }}>Kilogram
                                                                (kg)</option>
                                                            <option value="mg"
                                                                {{ $nitiItem->unit == 'mg' ? 'selected' : '' }}>Milligram
                                                                (mg)</option>
                                                            <option value="g"
                                                                {{ $nitiItem->unit == 'g' ? 'selected' : '' }}>Gram (g)
                                                            </option>
                                                            <option value="ltr"
                                                                {{ $nitiItem->unit == 'ltr' ? 'selected' : '' }}>Liter
                                                                (ltr)</option>
                                                            <option value="ml"
                                                                {{ $nitiItem->unit == 'ml' ? 'selected' : '' }}>Milliliter
                                                                (ml)</option>
                                                            <option value="pcs"
                                                                {{ $nitiItem->unit == 'pcs' ? 'selected' : '' }}>Pieces
                                                                (pcs)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-center mt-2">
                                                        <button type="button" class="btn btn-success add-item me-1">Add
                                                            Items</button>
                                                        <button type="button" class="btn btn-danger remove-item"
                                                            style="display: none;">Remove</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-1">NITI SEBAYAT</h4>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="main-content-label mg-b-5">SEBAYAT INVOLVED LIST</div>
                                                <select class="form-control select2" id="niti_sebayat" name="niti_sebayat[]" multiple="multiple">
                                                    <option value="">Select Sebak</option>
                                                    @foreach ($sebayat_list as $sebayat)
                                                        <option value="{{ $sebayat->sebayat_name }}"
                                                            {{ in_array($sebayat->sebayat_name, old('niti_sebayat', $selectedSebayats ?? [])) ? 'selected' : '' }}>
                                                            {{ $sebayat->sebayat_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-header">
                                            <h4 class="card-title mb-1">NITI STEP</h4>
                                        </div>

                                        <div class="step-container">
                                            @if (isset($nitiSteps) && count($nitiSteps) > 0)
                                                @foreach ($nitiSteps as $index => $step)
                                                    <div class="row step-item align-items-center mb-3">
                                                        <div class="col-md-6">
                                                            <div class="card-body">
                                                                <div class="main-content-label mg-b-5">NITI STEP
                                                                    {{ $index + 1 }}</div>
                                                                <input type="text" class="form-control"
                                                                    name="step_of_niti[]" value="{{ $step->step_name }}"
                                                                    placeholder="Enter Step Of Niti Name">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="card-body">
                                                                <div class="main-content-label mg-b-5">SEBA NAME</div>
                                                                <select class="form-control select2" name="seba_name[{{ $index }}][]" multiple="multiple">
                                                                    <option value="">Select Seba</option>
                                                                    @foreach ($manage_seba as $seba)
                                                                        <option value="{{ $seba->seba_name }}"
                                                                            @if (in_array($seba->seba_name, $step->seba_name))
                                                                                selected
                                                                            @endif>
                                                                            {{ $seba->seba_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    
                                                        

                                                        <div class="col-md-2 mt-3 d-flex justify-content-center">
                                                            @if ($index == count($nitiSteps) - 1)
                                                                <button type="button"
                                                                    class="btn btn-success add-step me-1">Add Step</button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-danger remove-step">Remove</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <!-- Default Step if no existing steps are present -->
                                                <div class="row step-item align-items-center mb-3">
                                                    <div class="col-md-6">
                                                        <div class="card-body">
                                                            <div class="main-content-label mg-b-5">NITI STEP 1</div>
                                                            <input type="text" class="form-control"
                                                                name="step_of_niti[]"
                                                                placeholder="Enter Step Of Niti Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="card-body">
                                                            <div class="main-content-label mg-b-5">SEBA NAME</div>
                                                            <select class="form-control select2" name="seba_name[{{ $index }}][]" multiple="multiple">
                                                                <option value="">Select Seba</option>
                                                                @foreach ($manage_seba as $seba)
                                                                    <option value="{{ $seba->seba_name }}"
                                                                        @if (in_array($seba->seba_name, $step->seba_name))
                                                                            selected
                                                                        @endif>
                                                                        {{ $seba->seba_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2 mt-3 d-flex justify-content-center">
                                                        <button type="button" class="btn btn-success add-step me-1">Add
                                                            Step</button>
                                                        <button type="button" class="btn btn-danger remove-step"
                                                            style="display: none;">Remove</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="main-content-label">Description</div>
                                        <textarea class="form-control" id="description" name="description" placeholder="Enter Niti Description">{{ old('description', $niti_master->description ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <input type="submit" class="btn btn-primary"
                                        value="{{ isset($niti_master) ? 'Update' : 'Submit' }}">
                                </div>
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
        $(document).ready(function() {
            $('.select2').select2();
        });

        setTimeout(function() {
            $('#Message').fadeOut('slow');
        }, 3000);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle Add Step
            document.querySelector('.add-step').addEventListener('click', function() {
                const lastStep = document.querySelector('.step-item:last-child');
                const newStep = lastStep.cloneNode(true); // Clone the last row

                const inputs = newStep.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.value = ''; // Clear the value
                    if (input.tagName === 'SELECT') {
                        $(input).val(null).trigger('change'); // For Select2 (if used)
                    }
                });

                const removeButton = newStep.querySelector('.remove-step');
                removeButton.style.display = 'inline-block';

                // Add the cloned row to the container
                document.querySelector('.step-container').appendChild(newStep);
            });

            // Handle Remove Step
            document.querySelector('.step-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-step')) {
                    const stepRow = event.target.closest('.step-item');
                    stepRow.remove();
                }
            });
        });
    </script>
    <script>
        let stepCount = 1; // Initialize the step counter

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-step')) {
                stepCount++;
                const stepContainer = document.querySelector('.step-container');
                const newStep = document.createElement('div');
                newStep.classList.add('row', 'step-item', 'align-items-center');

                // Template literal for dynamic HTML
                newStep.innerHTML = `
            <div class="col-md-6">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">NITI STEP ${stepCount}</div>
                    <input type="text" class="form-control" name="step_of_niti[]" placeholder="Enter Step Of Niti Name">
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">SEBA NAME</div>
                    <select class="form-control select2" name="seba_name[]" multiple="multiple">
                        <option value="">Select Seba</option>
                        ${`@foreach ($manage_seba as $seba)
                                        <option value="{{ $seba->seba_name }}">{{ $seba->seba_name }}</option>
                                    @endforeach`}
                    </select>
                </div>
            </div>
            <div class="col-md-2 mt-3 d-flex justify-content-center">
                <button type="button" class="btn btn-success add-step me-1">Add Step</button>
                <button type="button" class="btn btn-danger remove-step">Remove</button>
            </div>
        `;

                stepContainer.appendChild(newStep);

                // Initialize Select2 for the newly added dropdown
                $(newStep).find('.select2').select2();

                updateButtons();
            } else if (event.target.classList.contains('remove-step')) {
                event.target.closest('.step-item').remove();
                stepCount--;
                updateButtons();
            }
        });

        // Call this once on page load to initialize any existing select elements
        $(document).ready(function() {
            $('.select2').select2();
        });

        function updateButtons() {
            const steps = document.querySelectorAll('.step-item');
            steps.forEach((step, index) => {
                const addBtn = step.querySelector('.add-step');
                const removeBtn = step.querySelector('.remove-step');
                addBtn.style.display = index === steps.length - 1 ? 'inline-block' : 'none';
                removeBtn.style.display = steps.length > 1 ? 'inline-block' : 'none';
            });
        }

        // Call updateButtons initially to handle existing steps
        updateButtons();
    </script>

    <script>
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-item')) {
                const itemContainer = document.querySelector('.item-container');
                const newItemRow = document.querySelector('.item-row').cloneNode(true);

                // Clear values for the cloned input fields
                newItemRow.querySelectorAll('input').forEach(input => input.value = '');
                newItemRow.querySelector('select').selectedIndex = 0;

                // Update buttons
                newItemRow.querySelector('.add-item').style.display = 'none';
                newItemRow.querySelector('.remove-item').style.display = 'inline-block';

                itemContainer.appendChild(newItemRow);
            } else if (event.target.classList.contains('remove-item')) {
                event.target.closest('.item-row').remove();
            }
        });
    </script>
@endsection
