@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Edit Item</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href=""
                        class="btn btn-warning text-dark">Manage Item</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">Edit Item</li>
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
                    <form action="{{ route('templeuser.updateitem', $item->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" name="item_name" id="item_name" value="{{ $item->item_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description">{{ $item->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
{{-- sweet alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
