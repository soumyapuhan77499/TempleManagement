@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">EDIT YEARLY SPECIAL RITUAL</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Temple</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ritual</li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="custom-card main-content-body-profile">
                <div class="main-content-body tab-pane border-top-0" id="bank">
                    <!-- row -->
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
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

                    <!-- Update form -->
                    <form action="{{ route('update.yearly-ritual', $specialRitual->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="spcl_ritual_name">Special Ritual Name</label>
                                                    <input type="text" class="form-control" name="spcl_ritual_name"
                                                        value="{{ old('spcl_ritual_name', $specialRitual->spcl_ritual_name) }}" 
                                                        id="spcl_ritual_name" placeholder="Enter Special Ritual">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="spcl_ritual_date">Special Ritual Date</label>
                                                    <input type="date" class="form-control" name="spcl_ritual_date"
                                                        value="{{ old('spcl_ritual_date', $specialRitual->spcl_ritual_date) }}" 
                                                        id="spcl_ritual_date" placeholder="Enter Ritual Date">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="spcl_ritual_tithi">Special Ritual Tithi</label>
                                                    <input type="text" class="form-control" name="spcl_ritual_tithi" 
                                                        value="{{ old('spcl_ritual_tithi', $specialRitual->spcl_ritual_tithi) }}" 
                                                        id="spcl_ritual_tithi" placeholder="Enter Special Tithi">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="spcl_ritual_time">Special Ritual Time</label>
                                                    <div class="input-group">
                                                        <input type="time" class="form-control" name="spcl_ritual_time" 
                                                            value="{{ old('spcl_ritual_time', $specialRitual->spcl_ritual_time) }}" 
                                                            id="spcl_ritual_time" placeholder="Enter Ritual Time">
                                                        <select class="form-control" name="spcl_ritual_period" id="spcl_ritual_period">
                                                            <option value="AM" {{ $specialRitual->spcl_ritual_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                            <option value="PM" {{ $specialRitual->spcl_ritual_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="spcl_ritual_image">Special Ritual Image</label>
                                                    <input type="file" class="form-control" name="spcl_ritual_image" id="spcl_ritual_image">
                                                    @if ($specialRitual->spcl_ritual_image)
                                                        <small>Current Image: <a href="{{ asset($specialRitual->spcl_ritual_image) }}" target="_blank">View</a></small>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="spcl_ritual_video">Ritual Video</label>
                                                    <input type="file" class="form-control" name="spcl_ritual_video" id="spcl_ritual_video">
                                                    @if ($specialRitual->spcl_ritual_video)
                                                        <small>Current Video: <a href="{{ asset($specialRitual->spcl_ritual_video) }}" target="_blank">View</a></small>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $specialRitual->description) }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="text-center col-md-12">
                                            <button type="submit" class="btn btn-primary" style="width: 150px;">Update</button>
                                        </div>
                                    </div>
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
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>
@endsection
