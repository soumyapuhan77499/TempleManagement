@extends('templeuser.layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">BANK DETAILS</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Temple</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bank</li>
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
                    <form action="{{ url('templeuser/save-temple-bank')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name"
                                                        value="" id="bank_name"
                                                        placeholder="Enter Bank Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="branch_name">Branch Name</label>
                                                    <input type="text" class="form-control" name="branch_name"
                                                        value="" id="branch_name"
                                                        placeholder="Enter Branch Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="account_no">Account Number</label>
                                                    <input type="text" class="form-control" name="account_no"
                                                           value="" id="account_no"
                                                           placeholder="Enter Account Number" maxlength="17" oninput="validateAccountNumber(this)">
                                                    <small id="accNumberError" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ifsc_code">IFSC Code</label>
                                                    <input type="text" class="form-control" name="ifsc_code"
                                                           value="" id="ifsc_code"
                                                           placeholder="Enter IFSC Code" maxlength="15" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="acc_holder_name">Account Holder Name</label>
                                                    <input type="text" class="form-control" name="acc_holder_name"
                                                        value="" id="acc_holder_name"
                                                        placeholder="Enter Account Holder Name">
                                                </div>
                                            </div>
                                         
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="upi_id">UPI Number/ID</label>
                                                    <input type="text" class="form-control" name="upi_id"
                                                        value="" id="upi_id"
                                                        placeholder="Enter Account Number">
                                                </div>
                                            </div>
    
    
                                        </div>
                                        <div class="text-center col-md-12">
                                            <button type="submit" class="btn btn-primary"
                                                style="width: 150px;">Submit</button>
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
    setTimeout(function() {
        document.getElementById('Messages').style.display = 'none';
    }, 3000);
</script>
@endsection
