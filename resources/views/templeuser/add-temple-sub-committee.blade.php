@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

    @section('content')

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">Sub Committee Details</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Sub Committee Details</li>
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
							  <!-- Display validation errors -->
							@if ($errors->any())
							<div class="alert alert-danger" id="Message">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<!-- row  -->
							<div class="row">
								<div class="col-12 col-sm-12">
									<div class="card">
										<div class="card-body pt-0 pt-4">
												
											<form method="POST" enctype="multipart/form-data" action="{{ route('templeuser.storeTrustMember') }}">
												@csrf
												@method('POST') <!-- Assuming you're creating a new entry -->
											
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="committee_name">Name Of Committee <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="committee_name" name="committee_name" 
																value=""  >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="present_member">Add Member</label>
															<select multiple="multiple" class="testselect2" name="present_member[]">
																<option value="Member 1">Member 1</option>
																<option value="Member 2">Member 2</option>
																<option value="Member 3">Member 3</option>
																<option value="Member 4">Member 4</option>
															</select>
														</div>
													</div>
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

		
 <!--Internal  Form-elements js-->
 <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
 <script src="{{ asset('assets/js/advanced-form-elements.js') }}"></script>
 <script src="{{ asset('assets/js/select2.js') }}"></script>
 <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
 <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

 {{-- sweet alert --}}
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endsection
