@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Hundi</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <a class="btn ripple btn-success ms-2"  href="{{ route('templeuser.managehundi') }}">Manage Hundi</a>
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
    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-body pt-0 pt-4">
                    <form method="POST" action="{{ route('templeuser.savehundi') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="hundi_name">Hundi Name <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="hundi_name" name="hundi_name"
                                        placeholder="Enter Hundi Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description"> Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter Description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row closed -->


@endsection

@section('scripts')
@endsection
