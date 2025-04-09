@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Darshan Management</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Darshan</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-body pt-0 pt-4">
                    <form method="POST" action="{{ route('templeuser.saveDarshanManagement') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
