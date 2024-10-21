@extends('templeuser.layouts.app')

    @section('styles')

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

    @endsection

    @section('content')

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">Add Temple Inventory</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Temple Inventory</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->
							@if(session()->has('success'))
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
										{{-- <div class="card-header">
											<h4 class="card-title">Temple About</h4>
										</div> --}}
										<div class="card-body pt-0 pt-4">
											<form method="POST" action="{{ route('templeinventory.updateinventory', $inventory->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT') <!-- Use PUT method for update -->
                                                
                                                <!-- Hidden field for ID -->
                                                <input type="hidden" name="id" value="{{ $inventory->id }}">
                                            
                                                <div class="row">
                                                    <!-- Item Name -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="item_name">Item Name <span style="color:red">*</span></label>
                                                            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ old('item_name', $inventory->item_name) }}" placeholder="Enter Item Name" required>
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Quantity -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="quantity">Quantity <span style="color:red">*</span></label>
                                                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" placeholder="Enter Quantity" required>
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Item Description -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="item_desc">Item Description <span style="color:red">*</span></label>
                                                            <textarea name="item_desc" class="form-control" id="item_desc" placeholder="Enter Item Description" required>{{ old('item_desc', $inventory->item_desc) }}</textarea>
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Photo -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="photo">Photo <span style="color:red">*</span></label>
                                                            <input type="file" class="form-control" id="photo" name="photo">
                                                            @if($inventory->photo)
                                                                <img src="{{ asset('storage/' . $inventory->photo) }}" alt="Item Image" width="100">
                                                            @endif
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Inventory Category -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="inventory_category">Inventory Category <span style="color:red">*</span></label>
                                                            <select class="form-control" id="inventory_category" name="inventory_category" required>
                                                                <option value="">Select Category</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ $inventory->inventory_category == $category->id ? 'selected' : '' }}>
                                                                        {{ $category->inventory_category }} <!-- Display category name -->
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                            
                                                    <!-- Type -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="type">Type <span style="color:red">*</span></label>
                                                            <select name="type" class="form-control" id="type" required>
                                                                <option value="donated" {{ $inventory->type == 'donated' ? 'selected' : '' }}>Donated</option>
                                                                <option value="purchased" {{ $inventory->type == 'purchased' ? 'selected' : '' }}>Purchased</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                            
                                            
                                            
										</div>
									</div>
								</div>
							</div>
							<!-- /row closed -->


    @endsection

    @section('scripts')

		<!-- Internal Chart.Bundle js-->
		<script src="{{asset('assets/plugins/chartjs/Chart.bundle.min.js')}}"></script>

		<!-- Moment js -->
		<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>

		<!-- INTERNAL Apexchart js -->
		<script src="{{asset('assets/js/apexcharts.js')}}"></script>

		<!--Internal Sparkline js -->
		<script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

		<!--Internal  index js -->
		<script src="{{asset('assets/js/index.js')}}"></script>

        <!-- Chart-circle js -->
		<script src="{{asset('assets/js/chart-circle.js')}}"></script>

		<!-- Internal Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Select2 js -->
		<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
		<script src="{{asset('assets/js/select2.js')}}"></script>
	
			
    @endsection
