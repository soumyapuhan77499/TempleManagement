@extends('templeuser.layouts.app')

@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">Edit Inside Temple</span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Inside Temple</li>
        </ol>
    </div>
</div>
<!-- /breadcrumb -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success" id="Message">
        {{ session()->get('success') }}
    </div>
@endif

<!-- row -->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-body pt-0 pt-4">

                <form method="POST" action="{{ route('templeuser.updateinsidetemple', $temple->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inside_temple_name">Inside Temple Name <span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="inside_temple_name" name="inside_temple_name" value="{{ old('inside_temple_name', $temple->inside_temple_name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inside_temple_image">Inside Temple Image</label>
                                <input type="file" class="form-control" name="inside_temple_image" id="inside_temple_image">
                                @if($temple->inside_temple_image)
                                    <img src="{{ asset($temple->inside_temple_image) }}" alt="Current Image" width="100px" height="100px" class="mt-2">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inside_temple_about">Inside Temple About</label>
                        <textarea name="inside_temple_about" class="form-control" id="inside_temple_about">{{ old('inside_temple_about', $temple->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- /row closed -->

@endsection