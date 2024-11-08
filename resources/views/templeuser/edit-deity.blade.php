@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">EDIT DEITY</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-deity') }}"
                        class="btn btn-warning text-dark">Manage Deity</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">EDIT DEITY</li>
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

    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('updateDeity', $deity->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- PUT method for updating the resource -->
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Choose Language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="English" {{ old('language', $deity->language ?? '') == 'English' ? 'selected' : '' }}>English</option>
                                        <option value="Hindi" {{ old('language', $deity->language ?? '') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                        <option value="Odia" {{ old('language', $deity->language ?? '') == 'Odia' ? 'selected' : '' }}>Odia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deity_name">Deity Name</label>
                                    <input type="text" class="form-control" id="deity_name" name="deity_name"
                                        value="{{ old('deity_name', $deity->deity_name) }}" placeholder="Enter Deity Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Deity Type</label>
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="deity_type" name="deity_type" 
                                               value="1" {{ $deity->deity_type == 1 ? 'checked' : '' }} 
                                               style="width: 20px; height: 20px; margin-right: 20px;">
                                        <label class="form-check-label" for="deity_type" style="font-size: 16px;margin-left: 10px">Primary</label>
                                    </div>
                                    <small class="form-text text-danger mt-1">Check this box if this deity is a primary deity.</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description">{{ old('description', $deity->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <input type="submit" class="btn btn-primary" value="Update">
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
    <!-- Form-layouts js -->
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
@endsection
