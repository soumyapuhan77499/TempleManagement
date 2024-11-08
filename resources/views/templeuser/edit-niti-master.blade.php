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
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-niti') }}" class="btn btn-warning text-dark">Manage Niti</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">{{ isset($niti_master) ? 'EDIT NITI' : 'ADD NITI' }}</li>
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
                    
                    <form action="{{ isset($niti_master) ? route('updateNitiMaster', $niti_master->id) : route('saveNitiMaster') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Choose Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="English" {{ old('language', $niti_master->language ?? '') == 'English' ? 'selected' : '' }}>English</option>
                                        <option value="Hindi" {{ old('language', $niti_master->language ?? '') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                        <option value="Odia" {{ old('language', $niti_master->language ?? '') == 'Odia' ? 'selected' : '' }}>Odia</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="niti_name">Niti Name</label>
                                    <input type="text" class="form-control" id="niti_name" name="niti_name"
                                        value="{{ old('niti_name', $niti_master->niti_name ?? '') }}"
                                        placeholder="Enter Niti Name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sebak_name">Seba Name</label>
                                    <select class="form-control select2" id="seba_name" name="seba_name[]" multiple="multiple">
                                        <option value="">Select Seba</option>
                                        @foreach($manage_niti_master as $item)
                                            @foreach(explode(',', $item->seba_name) as $seba)
                                                <option value="{{ $seba }}" 
                                                        @if(isset($niti_master) && in_array($seba, explode(',', $niti_master->seba_name))) selected @endif>
                                                    {{ $seba }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="step-container">
                            @foreach ($niti_master->steps as $key => $step)
                                <div class="row step-item">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Step {{ $key + 1 }}</label>
                                            <input type="text" class="form-control" name="step_of_niti[]"
                                                value="{{ old('step_of_niti.' . $key, $step->step_name) }}"
                                                placeholder="Enter Step Of Niti Name">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success add-step">Add Step</button>
                                        <button type="button" class="btn btn-danger remove-step">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description">{{ old('description', $niti_master->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <input type="submit" class="btn btn-primary" value="{{ isset($niti_master) ? 'Update' : 'Submit' }}">
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
        let stepCount = {{ count($niti_master->steps) }};

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-step')) {
                stepCount++;
                const stepContainer = document.querySelector('.step-container');
                const newStep = document.createElement('div');
                newStep.classList.add('row', 'step-item');
                newStep.innerHTML = `
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Step ${stepCount}</label>
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
                updateButtons();
            }
        });

        function updateButtons() {
            const removeButtons = document.querySelectorAll('.remove-step');
            removeButtons.forEach(button => {
                button.style.display = removeButtons.length > 1 ? 'inline-block' : 'none';
            });
        }
    </script>
@endsection
