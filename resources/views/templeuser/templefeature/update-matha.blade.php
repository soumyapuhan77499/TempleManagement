@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">UPDATE PARKING DETAILS</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-parking') }}"
                        class="btn btn-warning text-dark">Add Parking</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">Parking</li>
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
                    <form action="{{ route('updateMatha', $matha->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Specify PUT method -->
                
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="matha_name">Matha Name</label>
                                    <input type="text" class="form-control" id="matha_name" name="matha_name" value="{{ $matha->matha_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="photo">Photo Upload</label>
                                    <input type="file" class="form-control" id="photo" name="photo[]" multiple>
                                    @if($matha->photo)
                                        <p>Current Photos:</p>
                                        @foreach(json_decode($matha->photo) as $image)
                                            <img src="{{ asset($image) }}" width="50">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="established_date">Established Date</label>
                                    <input type="date" class="form-control" id="established_date" name="established_date" value="{{ $matha->established_date }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="established_by">Established BY</label>
                                    <input type="text" class="form-control" id="established_by" name="established_by" value="{{ $matha->established_by }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="endowment">Endowment</label>
                                    <select class="form-control select2" id="endowment" name="endowment" required>
                                        <option value="yes" {{ $matha->endowment == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ $matha->endowment == 'no' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="availability">Availability</label>
                                    <select class="form-control select2" id="availability" name="availability" required>
                                        <option value="lodging" {{ $matha->availability == 'lodging' ? 'selected' : '' }}>Lodging</option>
                                        <option value="fooding" {{ $matha->availability == 'fooding' ? 'selected' : '' }}>Fooding</option>
                                        <option value="both" {{ $matha->availability == 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="google_map_link">Google Map Link</label>
                                    <input type="url" class="form-control" id="google_map_link" name="google_map_link" value="{{ $matha->google_map_link }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $matha->contact_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="whatsapp_no">WhatsApp No</label>
                                    <input type="text" class="form-control" id="whatsapp_no" name="whatsapp_no" value="{{ $matha->whatsapp_no }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email_id">Email ID</label>
                                    <input type="email" class="form-control" id="email_id" name="email_id" value="{{ $matha->email_id }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="relation_with_temple">Relation With Temple</label>
                                    <input type="text" class="form-control" id="relation_with_temple" name="relation_with_temple" value="{{ $matha->relation_with_temple }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ $matha->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $matha->description }}</textarea>
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
