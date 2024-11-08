@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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

    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">

                    <form action="{{ route('saveNitiMaster') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value=" ">Select language...</option>
                                        <option value="English">English</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Odia">Odia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="niti_name">Niti Name</label>
                                    <input type="text" class="form-control" id="niti_name" name="niti_name"
                                        placeholder="Enter Niti Name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sebak_name">Seba Name</label>
                                    <select class="form-control select2" id="seba_name" name="seba_name[]"
                                        multiple="multiple">
                                        <option value="">Select Sebak</option>
                                        @foreach ($manage_seba as $seba)
                                            <option value="{{ $seba->seba_name }}">{{ $seba->seba_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="step-container">
                            <div class="row step-item">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Niti Step 1</label>
                                        <input type="text" class="form-control" name="step_of_niti[]"
                                            placeholder="Enter Step Of Niti Name">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success add-step">Add Step</button>
                                    <button type="button" class="btn btn-danger remove-step"
                                        style="display: none;">Remove</button>
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
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
        let stepCount = 1;

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-step')) {
                stepCount++;
                const stepContainer = document.querySelector('.step-container');
                const newStep = document.createElement('div');
                newStep.classList.add('row', 'step-item');
                newStep.innerHTML = `
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Niti Step ${stepCount}</label>
                        <input type="text" class="form-control" name="step_of_niti[]" placeholder="Enter Step Of Niti Name">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success add-step">Add Step</button>
                    <button type="button" class="btn btn-danger remove-step">Remove</button>
                </div>
            `;
                stepContainer.appendChild(newStep);
                updateButtons();
            } else if (event.target.classList.contains('remove-step')) {
                event.target.closest('.step-item').remove();
                stepCount--;
                updateButtons();
            }
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

        updateButtons(); // Initial call to set up buttons
    </script>
@endsection
