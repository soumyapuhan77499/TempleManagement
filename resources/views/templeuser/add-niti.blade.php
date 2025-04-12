@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Include Select2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <style>
        .card-body {
            padding: 11px 10px 10px 10px !important;
        }
    </style>

    <style>
        /* Additional styling for alignment */
        .step-container .step-item {
            margin-bottom: 10px;
        }

        .step-container .card-body {
            padding: 10px;
        }

        .step-container .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD NITI</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-niti') }}"
                        class="btn btn-warning text-dark">Manage Niti</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">ADD NITI</li>
            </ol>
        </div>
    </div>
    <!-- End Breadcrumb -->

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

    @if ($errors->has('danger'))
        <div class="alert alert-danger" id="Message">
            {{ $errors->first('danger') }}
        </div>
    @endif

    <form action="{{ route('saveNitiMaster') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h4 class="card-title mb-1">NITI DETAILS</h4>
                        </div>

                        <div class="row">
                            <!-- Language Selection -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="main-content-label">Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="">Select language...</option>
                                        <option value="English">English</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Odia">Odia</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Niti Name Input -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="main-content-label">Niti Name</label>
                                    <input type="text" class="form-control" id="niti_name" name="niti_name"
                                        placeholder="Enter Niti Name">
                                </div>
                            </div>

                            <!-- Niti Type Checkboxes -->
                            <div class="col-md-3">
                                <label class="main-content-label d-block">Niti Type</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <label class="custom-switch mb-0">
                                        <span class="custom-switch-description">Special Niti</span>
                                        <input type="checkbox" name="niti_type" value="special" class="custom-switch-input"
                                            id="specialNiti" onchange="toggleNitiType('special')">
                                        <span
                                            class="custom-switch-indicator custom-switch-indicator-xl custom-square"></span>
                                    </label>
                                    <label class="custom-switch mb-0">
                                        <span class="custom-switch-description">Daily Niti</span>
                                        <input type="checkbox" name="niti_type" value="daily" class="custom-switch-input"
                                            id="dailyNiti" onchange="toggleNitiType('daily')">
                                        <span
                                            class="custom-switch-indicator custom-switch-indicator-xl custom-square"></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Niti Privacy -->
                            <div class="col-md-3">
                                <label class="main-content-label d-block">Niti Privacy</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <label class="custom-switch mb-0">
                                        <span class="custom-switch-description">Public</span>
                                        <input type="checkbox" name="niti_privacy" value="public"
                                            class="custom-switch-input" id="publicNiti" onchange="togglePrivacy('public')">
                                        <span
                                            class="custom-switch-indicator custom-switch-indicator-xl custom-square"></span>
                                    </label>
                                    <label class="custom-switch mb-0">
                                        <span class="custom-switch-description">Private</span>
                                        <input type="checkbox" name="niti_privacy" value="private"
                                            class="custom-switch-input" id="privateNiti"
                                            onchange="togglePrivacy('private')">
                                        <span
                                            class="custom-switch-indicator custom-switch-indicator-xl custom-square"></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="col-md-3" id="dateTimeContainer">
                                <div class="form-group">
                                    <label class="main-content-label">Date & Time</label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                        <input class="form-control" id="datetimepicker" name="date_time" type="text"
                                            placeholder="YYYY-MM-DD HH:MM">
                                    </div>
                                </div>
                            </div>


                            <!-- Niti About -->
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label class="main-content-label">Niti About</label>
                                    <textarea class="form-control" id="niti_about" name="niti_about" rows="3" placeholder="Enter Niti About"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-1">NITI ITEMS</h4>
                    </div>
                    <div class="card-body">
                        <div class="item-container">
                            <div class="row item-row align-items-center mb-3">
                                <div class="col-md-4">
                                    <div class="main-content-label mg-b-5">Item Name</div>
                                    <input type="text" class="form-control" name="item_name[]"
                                        placeholder="Enter Item Name">
                                </div>
                                <div class="col-md-3">
                                    <div class="main-content-label mg-b-5">Quantity</div>
                                    <input type="text" class="form-control" name="quantity[]"
                                        placeholder="Enter Quantity">
                                </div>
                                <div class="col-md-3">
                                    <div class="main-content-label mg-b-5">Unit</div>
                                    <select class="form-control" name="unit[]">
                                        <option value="">Select Unit</option>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="mg">Milligram (mg)</option>
                                        <option value="g">Gram (g)</option>
                                        <option value="ltr">Liter (ltr)</option>
                                        <option value="ml">Milliliter (ml)</option>
                                        <option value="pcs">Pieces (pcs)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-center mt-2">
                                    <button type="button" class="btn btn-success add-item me-1">Add Items</button>
                                    <button type="button" class="btn btn-danger remove-item"
                                        style="display: none;">Remove</button>
                                </div>
                            </div>
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
                                <select class="form-control select2" id="niti_sebayat" name="niti_sebayat[]"
                                    multiple="multiple">
                                    <option value="">Select Sebak</option>
                                    @foreach ($sebayat_list as $sebayat)
                                        <option value="{{ $sebayat->sebayat_name }}">{{ $sebayat->sebayat_name }}
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
                            <div class="row step-item align-items-center">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="main-content-label mg-b-5">NITI STEP 1</div>
                                        <input type="text" class="form-control" name="step_of_niti[]"
                                            placeholder="Enter Step Of Niti Name">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card-body">
                                        <div class="main-content-label mg-b-5">SEBA NAME</div>
                                        <select class="form-control select2" name="seba_name[]" multiple="multiple">
                                            <option value="">Select Seba</option>
                                            @foreach ($manage_seba as $seba)
                                                <option value="{{ $seba->seba_name }}">{{ $seba->seba_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2 mt-3 d-flex justify-content-center">
                                    <button type="button" class="btn btn-success add-step me-1">Add Step</button>
                                    <button type="button" class="btn btn-danger remove-step"
                                        style="display: none;">Remove</button>
                                </div>
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
                        <div class="main-content-label">Description</div>
                        <textarea class="form-control" id="description" name="description" placeholder="Enter Niti Description"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-warning">SAVE NITI DETAILS</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('modal')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!--Internal  jquery.maskedinput js -->+
    <script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>

    <!-- Ionicons js -->
    <script src="{{ asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

    <!--Internal  pickerjs js -->
    <script src="{{ asset('assets/plugins/pickerjs/picker.min.js') }}"></script>

    <!--internal color picker js-->
    <script src="{{ asset('assets/plugins/colorpicker/pickr.es5.min.js') }}"></script>
    <script src="{{ asset('assets/js/colorpicker.js') }}"></script>

    <!--Bootstrap-datepicker js-->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Internal form-elements js -->
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        setTimeout(function() {
            $('#Message').fadeOut('slow');
        }, 3000);
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const datetimeInput = document.getElementById("datetimepicker");

            // Get the current date and time
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            // Format as 'YYYY-MM-DD HH:MM'
            const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}`;

            // Set the value of the input field
            datetimeInput.value = formattedDateTime;
        });
    </script>

    <script>
        function toggleNitiType(selectedType) {
            if (selectedType === 'special') {
                document.getElementById('dailyNiti').checked = false;
            } else if (selectedType === 'daily') {
                document.getElementById('specialNiti').checked = false;
            }
        }
    </script>

    <script>
        function togglePrivacy(selectedPrivacy) {
            if (selectedPrivacy === 'public') {
                document.getElementById('privateNiti').checked = false;
            } else if (selectedPrivacy === 'private') {
                document.getElementById('publicNiti').checked = false;
            }
        }
    </script>

    <script>
        function toggleNitiType(selectedType) {
            const specialCheckbox = document.getElementById('specialNiti');
            const dailyCheckbox = document.getElementById('dailyNiti');
            const dateTimeContainer = document.getElementById('dateTimeContainer');

            if (selectedType === 'special') {
                dailyCheckbox.checked = false;
                dateTimeContainer.style.display = 'block';
            }

            if (selectedType === 'daily') {
                specialCheckbox.checked = false;
                dateTimeContainer.style.display = 'none';
            }
        }

        // Run on load in case of page reload with old values
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('dailyNiti').checked) {
                document.getElementById('dateTimeContainer').style.display = 'none';
            } else {
                document.getElementById('dateTimeContainer').style.display = 'block';
            }
        });
    </script>
@endsection
