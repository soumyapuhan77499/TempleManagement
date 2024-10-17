@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{ isset($expenditure) ? 'Edit Temple Expenditure' : 'Add Temple Expenditure' }}</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Temple Expenditure</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->
    
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
                    <form method="POST" enctype="multipart/form-data" action="{{ isset($expenditure) ? route('templeuser.updateexpenditure', $expenditure->id) : route('templeuser.saveexpenditure') }}">
                        @csrf
                        @if(isset($expenditure))
                            @method('PUT') <!-- Use PUT method for update -->
                        @endif
                    
                        <div id="mandap_section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="mandap_fields">
                                        <div class="mandap-field-group">
                                            <div class="row">
                                                <!-- Person Name -->
                                                <div class="form-group col-md-4">
                                                    <label for="person_name">Person Name <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="person_name" placeholder="Person Name" value="{{ isset($expenditure) ? $expenditure->person_name : '' }}" required>
                                                </div>
                    
                                                <!-- Payment Date -->
                                                <div class="form-group col-md-4">
                                                    <label for="payment_date">Payment Date and Time <span style="color:red">*</span></label>
                                                    <input type="datetime-local" class="form-control" name="payment_date" value="{{ isset($expenditure) ? \Carbon\Carbon::parse($expenditure->payment_date)->format('Y-m-d\TH:i') : '' }}" required>
                                                </div>
                                                

                                                <!-- Amount -->
                                                <div class="form-group col-md-4">
                                                    <label for="amount">Amount <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="amount" placeholder="Amount" value="{{ isset($expenditure) ? $expenditure->amount : '' }}" required>
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <!-- Category -->
                                                <div class="form-group col-md-6">
                                                    <label for="category">Category <span style="color:red">*</span></label>
                                                    <select name="category" class="form-control" onchange="toggleCategoryType(this)" required>
                                                        <option value="">Select..</option>
                                                        <option value="Vendor" {{ (isset($expenditure) && $expenditure->category == 'Vendor') ? 'selected' : '' }}>Vendor</option>
                                                        <option value="Salary" {{ (isset($expenditure) && $expenditure->category == 'Salary') ? 'selected' : '' }}>Salary</option>
                                                        <option value="Selling" {{ (isset($expenditure) && $expenditure->category == 'Selling') ? 'selected' : '' }}>Selling</option>
                                                    </select>
                                                </div>
                                                
                                                <!-- Category Type -->
                                                <div class="form-group col-md-6">
                                                    <label for="category_type">Category Type <span style="color:red">*</span></label>
                                                    <select name="category_type" id="category_type" class="form-control" required>
                                                        <option value="">Select..</option>
                                                        @if(isset($expenditure) && $expenditure->category_type)
                                                            <option value="{{ $expenditure->category_type }}" selected>{{ $expenditure->category_type }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <!-- Payment Mode -->
                                                <div class="form-group col-md-4">
                                                    <label for="payment_mode">Payment Mode <span style="color:red">*</span></label>
                                                    <select name="payment_mode" class="form-control" id="payment_mode" onchange="togglePaymentIdField()" required>
                                                        <option value="CASH" {{ (isset($expenditure) && $expenditure->payment_mode == 'CASH') ? 'selected' : '' }}>CASH</option>
                                                        <option value="UPI" {{ (isset($expenditure) && $expenditure->payment_mode == 'UPI') ? 'selected' : '' }}>UPI</option>
                                                        <option value="IMPS" {{ (isset($expenditure) && $expenditure->payment_mode == 'IMPS') ? 'selected' : '' }}>IMPS</option>
                                                        <option value="CHEQUE" {{ (isset($expenditure) && $expenditure->payment_mode == 'CHEQUE') ? 'selected' : '' }}>CHEQUE</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-md-4" id="payment_id_field">
                                                    <label for="payment_number" id="payment_id_label">Payment Number <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="payment_number" id="payment_id" placeholder="" value="{{ isset($expenditure) ? $expenditure->payment_number : '' }}" required>
                                                </div>
                                                
                                                <!-- Payment Done By -->
                                                <div class="form-group col-md-4">
                                                    <label for="payment_done_by">Payment Done By <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="payment_done_by" placeholder="Payment Done By" value="{{ isset($expenditure) ? $expenditure->payment_done_by : '' }}" required>
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <!-- Payment Description -->
                                                <div class="form-group col-md-12">
                                                    <label for="payment_description">Payment Description</label>
                                                    <textarea class="form-control" name="payment_description" placeholder="Payment Description">{{ isset($expenditure) ? $expenditure->payment_description : '' }}</textarea>
                                                </div>
                                            </div>
                    
                                            <!-- Submit Button -->
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary mt-3">{{ isset($expenditure) ? 'Update' : 'Submit' }}</button>
                                            </div>
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
    <!-- /row closed -->
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function toggleCategoryType(selectElement) {
        var category = selectElement.value;
    
        if (category === 'Vendor') {
            // Make an AJAX request to fetch vendor names
            $.ajax({
                url: "{{ route('templeuser.getVendors') }}", // Correct route to fetch vendors
                type: "GET",
                success: function(data) {
                    // Check if data is returned and is an array
                    if (Array.isArray(data) && data.length > 0) {
                        // Populate the category_type dropdown
                        $('#category_type').empty(); // Clear existing options
                        $('#category_type').append('<option value="">Select Vendor</option>');
                        data.forEach(function(vendor) {
                            $('#category_type').append('<option value="' + vendor.vendor_name + '">' + vendor.vendor_name + '</option>');
                        });
                    } else {
                        // Handle no vendors returned
                        $('#category_type').empty();
                        $('#category_type').append('<option value="">No Vendors Available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    $('#category_type').empty();
                    $('#category_type').append('<option value="">Error fetching vendors</option>');
                }
            });
        } else {
            $('#category_type').empty().append('<option value="">Select..</option>');
        }
    }
</script>

@endsection
